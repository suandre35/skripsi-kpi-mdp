<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PeriodeEvaluasi;
use App\Models\Karyawan;
use App\Models\Divisi;
use App\Models\KategoriKpi;
use App\Models\PenilaianHeader;
use App\Models\PenilaianDetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class KpiSimulationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Buat Periode Evaluasi Q1 2025
        $periode = PeriodeEvaluasi::create([
            'nama_periode'    => 'Q1 2025',
            'tanggal_mulai'   => Carbon::now()->startOfMonth(),
            'tanggal_selesai' => Carbon::now()->addMonths(2)->endOfMonth(),
            'pengumuman'      => false,
            'status'          => true, // Aktif
        ]);

        $this->command->info("✅ Periode Evaluasi '{$periode->nama_periode}' berhasil dibuat.");

        // 2. Ambil Semua Manajer untuk menjadi Penilai
        $managers = Karyawan::with('user')
            ->whereHas('user', function($q) {
                $q->where('role', 'Manajer');
            })->get()->keyBy('id_divisi'); // Key by ID Divisi agar mudah dicari

        // 3. Ambil Semua Karyawan (Staff)
        $staffs = Karyawan::with('divisi')
            ->whereHas('user', function($q) {
                $q->where('role', 'Karyawan');
            })->whereNotNull('id_divisi')->get();

        // 4. Ambil Semua Indikator KPI (Eager load Target & Bobot)
        $allKategoris = KategoriKpi::with(['indikators.target'])->get();

        $countHeader = 0;
        $countDetail = 0;

        foreach ($staffs as $staff) {
            $divisiId = $staff->id_divisi;
            
            // Tentukan Penilai: Manajer dari divisi karyawan tersebut
            // Jika tidak ada manajer di divisi itu, pakai User ID 1 (Admin/HRD) sebagai fallback
            $penilaiId = $managers[$divisiId]->user->id_user ?? 1;

            // Buat Header Penilaian
            $header = PenilaianHeader::create([
                'id_karyawan' => $staff->id_karyawan,
                'id_periode'  => $periode->id_periode,
                'id_penilai'  => $penilaiId,
                'created_at'  => Carbon::now()->subDays(rand(1, 10)), // Random tanggal input
            ]);
            $countHeader++;

            // Loop semua kategori & indikator untuk mencari yang cocok dengan divisi staff ini
            foreach ($allKategoris as $kategori) {
                foreach ($kategori->indikators as $indikator) {
                    
                    // Cek apakah indikator ini ditujukan untuk divisi karyawan ini?
                    // target_divisi disimpan sebagai JSON array string ["1", "2"]
                    $targetDivisi = $indikator->target_divisi ?? [];
                    
                    // Pastikan tipe data array agar in_array berfungsi
                    if (is_string($targetDivisi)) {
                        $targetDivisi = json_decode($targetDivisi, true);
                    }

                    if (in_array((string)$divisiId, $targetDivisi)) {
                        
                        // --- GENERATE NILAI DUMMY ---
                        $nilaiTarget = $indikator->target->nilai_target ?? 100;
                        $jenisTarget = $indikator->target->jenis_target ?? 'Maksimal';
                        $satuan      = $indikator->satuan_pengukuran;

                        $nilaiInput = 0;

                        // Logika Nilai Random yang Realistis (70% - 110% dari target)
                        if ($satuan == 'Skala 1-5') {
                            // Random float antara 3.0 sampai 5.0
                            $nilaiInput = rand(30, 50) / 10; 
                        } elseif ($satuan == 'Persentase') {
                            // Random antara 70 sampai 100 (atau lebih dikit)
                            $nilaiInput = rand(85, 105); 
                        } elseif ($satuan == 'Skala 1-100') {
                            $nilaiInput = rand(75, 98);
                        } else {
                            // Default fallback
                            $nilaiInput = $nilaiTarget; 
                        }

                        // Buat Detail Penilaian
                        PenilaianDetail::create([
                            'id_penilaianHeader' => $header->id_penilaianHeader,
                            'id_indikator'       => $indikator->id_indikator,
                            'nilai_input'        => $nilaiInput,
                            'catatan'            => $this->getRandomComment(),
                            'created_at'         => $header->created_at,
                        ]);
                        $countDetail++;
                    }
                }
            }
        }

        $this->command->info("🎉 Selesai! Berhasil membuat {$countHeader} header penilaian dan {$countDetail} detail penilaian.");
    }

    /**
     * Helper untuk membuat komentar acak
     */
    private function getRandomComment()
    {
        $comments = [
            'Kinerja sangat baik, pertahankan.',
            'Cukup memuaskan, namun perlu teliti lagi.',
            'Sudah mencapai target.',
            'Perlu peningkatan di bulan depan.',
            'Excellent performance!',
            null, // Kadang tidak ada catatan
            null,
            'Terima kasih atas kerja kerasnya.',
        ];

        return $comments[array_rand($comments)];
    }
}