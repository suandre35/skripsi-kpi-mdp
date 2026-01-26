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
        // 1. Ambil Data Master Sekali Saja (Agar hemat query)
        
        // Ambil Semua Manajer (Key by ID Divisi)
        $managers = Karyawan::with('user')
            ->whereHas('user', function($q) {
                $q->where('role', 'Manajer');
            })->get()->keyBy('id_divisi');

        // Ambil Semua Karyawan (Staff)
        $staffs = Karyawan::with('divisi')
            ->whereHas('user', function($q) {
                $q->where('role', 'Karyawan');
            })->whereNotNull('id_divisi')->get();

        // Ambil Semua Indikator KPI
        $allKategoris = KategoriKpi::with(['indikators.target'])->get();

        // 2. Definisi Daftar Periode (Q1 2024 s/d Q1 2025)
        $listPeriode = [
            [
                'nama' => 'Q1 2024',
                'start' => Carbon::create(2024, 1, 1),
                'end'   => Carbon::create(2024, 3, 31),
                'status'=> false // Sudah tutup
            ],
            [
                'nama' => 'Q2 2024',
                'start' => Carbon::create(2024, 4, 1),
                'end'   => Carbon::create(2024, 6, 30),
                'status'=> false
            ],
            [
                'nama' => 'Q3 2024',
                'start' => Carbon::create(2024, 7, 1),
                'end'   => Carbon::create(2024, 9, 30),
                'status'=> false
            ],
            [
                'nama' => 'Q4 2024',
                'start' => Carbon::create(2024, 10, 1),
                'end'   => Carbon::create(2024, 12, 31),
                'status'=> false
            ],
            [
                'nama' => 'Q1 2025',
                'start' => Carbon::create(2025, 1, 1),
                'end'   => Carbon::create(2025, 3, 31),
                'status'=> true // Periode Aktif Sekarang
            ],
        ];

        $countHeader = 0;
        $countDetail = 0;

        // 3. Loop Setiap Periode
        foreach ($listPeriode as $pData) {
            
            // Buat Periode di Database
            $periode = PeriodeEvaluasi::create([
                'nama_periode'    => $pData['nama'],
                'tanggal_mulai'   => $pData['start'],
                'tanggal_selesai' => $pData['end'],
                'pengumuman'      => !$pData['status'], // Yang lama sudah diumumkan
                'status'          => $pData['status'],
            ]);

            $this->command->info("📅 Memproses Periode: {$periode->nama_periode}...");

            // 4. Loop Setiap Staff untuk Periode Ini
            foreach ($staffs as $staff) {
                $divisiId = $staff->id_divisi;
                
                // Tentukan Penilai (Manajer Divisi ybs / Fallback Admin)
                $penilaiId = $managers[$divisiId]->user->id_user ?? 1;

                // Buat Header Penilaian
                // Kita acak tanggal created_at sesuai rentang periode agar terlihat real
                $randomDate = $pData['start']->copy()->addDays(rand(1, 80));

                $header = PenilaianHeader::create([
                    'id_karyawan' => $staff->id_karyawan,
                    'id_periode'  => $periode->id_periode,
                    'id_penilai'  => $penilaiId,
                    'created_at'  => $randomDate,
                    'updated_at'  => $randomDate,
                ]);
                $countHeader++;

                // 5. Isi Detail Nilai KPI
                foreach ($allKategoris as $kategori) {
                    foreach ($kategori->indikators as $indikator) {
                        
                        // Cek Target Divisi
                        $targetDivisi = $indikator->target_divisi ?? [];
                        if (is_string($targetDivisi)) {
                            $targetDivisi = json_decode($targetDivisi, true);
                        }

                        // Jika indikator ini cocok untuk divisi karyawan
                        if (in_array((string)$divisiId, $targetDivisi)) {
                            
                            $nilaiTarget = $indikator->target->nilai_target ?? 100;
                            $satuan      = $indikator->satuan_pengukuran;
                            $nilaiInput  = 0;

                            // --- LOGIKA NILAI RANDOM AGAR GRAFIK NAIK TURUN ---
                            // Kita buat variasi agar ada yang performa naik, ada yang turun
                            
                            // Faktor keberuntungan karyawan ini (setiap karyawan punya hoki beda tiap periode)
                            $luckFactor = rand(-15, 15); // +/- 15% deviasi dari target

                            if ($satuan == 'Skala 1-5') {
                                // Base 4.0 + luck
                                $base = 40; // 4.0
                                $result = $base + $luckFactor; 
                                // Clamp min 20 max 50
                                $result = max(20, min(50, $result));
                                $nilaiInput = $result / 10; 

                            } elseif ($satuan == 'Persentase') {
                                // Base 100% + luck
                                $base = 100;
                                $result = $base + $luckFactor;
                                // Clamp min 60 max 120
                                $nilaiInput = max(60, min(125, $result));

                            } elseif ($satuan == 'Skala 1-100') {
                                // Base 85 + luck
                                $base = 85;
                                $result = $base + $luckFactor;
                                $nilaiInput = max(50, min(100, $result));

                            } else {
                                $nilaiInput = $nilaiTarget; 
                            }

                            // Buat Detail
                            PenilaianDetail::create([
                                'id_penilaianHeader' => $header->id_penilaianHeader,
                                'id_indikator'       => $indikator->id_indikator,
                                'nilai_input'        => $nilaiInput,
                                'catatan'            => $this->getRandomComment(),
                                'created_at'         => $randomDate,
                                'updated_at'         => $randomDate,
                            ]);
                            $countDetail++;
                        }
                    }
                }
            }
        }

        $this->command->info("🎉 SELESAI! Total {$countHeader} Laporan & {$countDetail} Detail Nilai dibuat untuk 5 Periode.");
    }

    /**
     * Helper untuk membuat komentar acak
     */
    private function getRandomComment()
    {
        $comments = [
            'Kinerja stabil.',
            'Target tercapai dengan baik.',
            'Perlu ditingkatkan lagi bulan depan.',
            'Excellent performance!',
            null, 
            null,
            null, // Perbanyak null agar tidak spam komentar
            'Good job.',
            'Ada sedikit keterlambatan, mohon diperbaiki.',
        ];

        return $comments[array_rand($comments)];
    }
}