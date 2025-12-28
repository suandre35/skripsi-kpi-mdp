<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\PenilaianHeader;
use App\Models\PenilaianDetail;
use App\Models\Karyawan;
use App\Models\PeriodeEvaluasi;
use App\Models\KategoriKpi;
use App\Models\Divisi;

class PenilaianController extends Controller
{
    /**
     * Tampilkan Riwayat Log Aktivitas (Dashboard Monitoring)
     */
    public function index()
    {
        // PERBAIKAN: Ambil data DETAIL (Log), bukan Header
        $logs = PenilaianDetail::with(['header.karyawan', 'indikator.target'])
                    ->whereHas('header', function($q) {
                        $q->where('id_penilai', Auth::id());
                    })
                    ->orderBy('tanggal', 'desc')
                    ->orderBy('created_at', 'desc')
                    ->paginate(20);

        // Kirim variabel $logs agar cocok dengan view index.blade.php
        return view('manajer.penilaian.index', compact('logs'));
    }

    /**
     * Form Input Log Harian
     */
    public function create()
    {
        $userLogin = Auth::user();

        // 1. Cek Divisi Manajer
        $divisiDipimpin = Divisi::where('id_manajer', $userLogin->id_user)
                                ->where('status', 'Aktif')
                                ->first();

        if (!$divisiDipimpin) {
            return redirect()->route('dashboard')->with('error', 'Akses Ditolak! Anda bukan Kepala Divisi.');
        }

        // 2. Cek Periode Aktif
        $periodeAktif = PeriodeEvaluasi::where('status', 'Aktif')->first();
        if (!$periodeAktif) {
            return redirect()->route('penilaian.index')->with('error', 'Tidak ada periode aktif.');
        }

        // 3. Ambil Karyawan (Bawahan Divisi)
        $karyawans = Karyawan::where('status_karyawan', 'Aktif')
                             ->where('id_divisi', $divisiDipimpin->id_divisi)
                             ->where('id_user', '!=', $userLogin->id_user)
                             ->get();

        // 4. Ambil Struktur KPI Sesuai Divisi (Logic JSON Column)
        $myDivisiId = (string) $divisiDipimpin->id_divisi;

        $kategoris = KategoriKpi::with(['indikators' => function($query) {
            $query->where('status', 'Aktif')
                  ->with('target'); // Load Data Target
        }])->where('status', 'Aktif')->get();

        // Filter Indikator yang target_divisi-nya cocok dengan divisi manajer
        $kategoris = $kategoris->map(function ($kategori) use ($myDivisiId) {
            $filteredIndikators = $kategori->indikators->filter(function ($indikator) use ($myDivisiId) {
                // Ambil array target_divisi, jika null anggap array kosong
                $targets = $indikator->target_divisi ?? [];
                // Cek apakah ID divisi manajer ada di dalam target indikator
                return in_array($myDivisiId, $targets);
            });
            $kategori->setRelation('indikators', $filteredIndikators);
            return $kategori;
        })->filter(fn($k) => $k->indikators->isNotEmpty());

        return view('manajer.penilaian.create', compact('periodeAktif', 'karyawans', 'kategoris'));
    }

    /**
     * Simpan Log Harian
     */
    public function store(Request $request)
    {
        // 1. Validasi Data
        $request->validate([
            'id_karyawan' => 'required|exists:karyawans,id_karyawan',
            'id_periode'  => 'required|exists:periode_evaluasis,id_periode',
            'tanggal'     => 'required|date',
            // Kita hapus validasi 'required' pada array aktivitas agar tidak error jika user lupa isi
            // Validasi isinya saja:
            'aktivitas.*.nilai' => 'nullable|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            // Cek apakah ada minimal SATU data yang diisi?
            $hasData = false;
            if ($request->has('aktivitas')) {
                foreach ($request->aktivitas as $data) {
                    if (isset($data['nilai']) && $data['nilai'] !== null && $data['nilai'] !== '') {
                        $hasData = true;
                        break;
                    }
                }
            }

            if (!$hasData) {
                // Jika user klik simpan tapi kosong semua, kembalikan dengan error
                return redirect()->back()->with('error', 'Mohon isi minimal satu hasil pekerjaan sebelum menyimpan.');
            }

            // ... Lanjut proses simpan Header & Detail (Kode sama seperti sebelumnya) ...
            
            $header = PenilaianHeader::firstOrCreate(
                [
                    'id_karyawan' => $request->id_karyawan,
                    'id_periode'  => $request->id_periode,
                ],
                [
                    'id_penilai'        => Auth::id(),
                    'tanggal_penilaian' => now(),
                    'total_nilai'       => 0 
                ]
            );

            foreach ($request->aktivitas as $id_indikator => $data) {
                if (isset($data['nilai']) && $data['nilai'] !== null && $data['nilai'] !== '') {
                    PenilaianDetail::create([
                        'id_penilaianHeader' => $header->id_penilaianHeader,
                        'id_indikator'       => $id_indikator,
                        'tanggal'            => $request->tanggal,
                        'nilai_input'        => $data['nilai'],
                        'catatan'            => $data['catatan'] ?? null,
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('penilaian.index')->with('success', 'Log aktivitas harian berhasil disimpan!');

        } catch (\Exception $e) {
            DB::rollback();
            // Pesan error ini sekarang AKAN MUNCUL di layar berkat update View tadi
            return redirect()->back()->with('error', 'Gagal menyimpan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Tampilkan Form Edit untuk Log Spesifik
     */ 
    public function edit($id)
    {
        // Ambil data log beserta info karyawan & indikatornya
        $log = PenilaianDetail::with(['header.karyawan', 'indikator.target'])->findOrFail($id);

        // Security: Pastikan yang edit adalah penilai yang sama (Opsional tapi disarankan)
        if ($log->header->id_penilai != Auth::id()) {
            return redirect()->route('penilaian.index')->with('error', 'Anda tidak memiliki akses untuk mengedit log ini.');
        }

        return view('manajer.penilaian.edit', compact('log'));
    }

    /**
     * Simpan Perubahan Log
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nilai_input' => 'required|numeric|min:0',
            'catatan'     => 'nullable|string|max:255',
        ]);

        try {
            $log = PenilaianDetail::findOrFail($id);

            // Update Data
            $log->update([
                'nilai_input' => $request->nilai_input,
                'catatan'     => $request->catatan,
                // Jika ingin tanggal bisa diedit juga, uncomment baris ini:
                // 'tanggal'     => $request->tanggal, 
            ]);

            return redirect()->route('penilaian.index')->with('success', 'Log aktivitas berhasil diperbarui!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal update: ' . $e->getMessage());
        }
    }

    /**
     * Hapus Log Aktivitas (Jika salah input)
     */
    public function destroy($id)
    {
        try {
            $log = PenilaianDetail::findOrFail($id);
            
            // Pastikan yang menghapus adalah penilai yang bersangkutan (Security check)
            if ($log->header->id_penilai != Auth::id()) {
                abort(403, 'Anda tidak berhak menghapus data ini.');
            }

            $log->delete();

            return redirect()->back()->with('success', 'Log aktivitas berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus data.');
        }
    }

    /**
     * Halaman Rapor Kinerja Tim (Khusus Manajer)
     */
    public function laporan(Request $request)
    {
        // 1. Ambil Data Manajer yang Login
        $user = Auth::user();
        $manajer = Karyawan::with('divisi')->where('id_user', $user->id_user)->first();

        if (!$manajer) {
            return redirect()->route('dashboard')->with('error', 'Profil Manajer belum lhou!');
        }

        // 2. Filter Periode
        $periodes = PeriodeEvaluasi::all();
        $periodeAktif = PeriodeEvaluasi::where('status', 'Aktif')->first();
        $selectedPeriode = $request->id_periode ?? ($periodeAktif ? $periodeAktif->id_periode : null);

        // 3. Ambil Karyawan (HANYA Satu Divisi dengan Manajer)
        $karyawans = Karyawan::where('id_divisi', $manajer->id_divisi)
                             ->where('status_karyawan', 'Aktif')
                             ->where('id_karyawan', '!=', $manajer->id_karyawan) // Opsional: Manajer tidak menilai diri sendiri disini
                             ->get();

        // 4. Hitung Skor Ringkas
        foreach ($karyawans as $k) {
            if ($selectedPeriode) {
                // Panggil fungsi hitung (sama seperti di HRD)
                $k->skor_saat_ini = $this->hitungSkorPrivate($k->id_karyawan, $selectedPeriode, $manajer->id_divisi);
            } else {
                $k->skor_saat_ini = 0;
            }
        }

        return view('manajer.penilaian.laporan', compact('karyawans', 'periodes', 'selectedPeriode', 'manajer'));
    }

    /**
     * Detail Rapor Anggota Tim
     */
    public function detailLaporan($id_karyawan)
    {
        $karyawan = Karyawan::findOrFail($id_karyawan);
        
        // Validasi: Pastikan Karyawan ini satu divisi dengan Manajer yang login (Security Check)
        $user = Auth::user();
        $manajer = Karyawan::where('id_user', $user->id_user)->first();
        if($manajer->id_divisi != $karyawan->id_divisi){
            abort(403, 'Anda tidak berhak melihat rapor divisi lain.');
        }

        $periode = PeriodeEvaluasi::where('status', 'Aktif')->first();
        // Jika mau lihat history, bisa dimodifikasi ambil dari request param
        
        if(!$periode) {
            return redirect()->back()->with('error', 'Tidak ada periode aktif.');
        }

        $dataRapor = $this->getDetailSkorPrivate($id_karyawan, $periode->id_periode, $karyawan->id_divisi);

        return view('manajer.penilaian.detail', compact('karyawan', 'periode', 'dataRapor'));
    }

    // --- HELPER FUNCTION (Copy logic kalkulasi agar mandiri) ---
    private function hitungSkorPrivate($idKaryawan, $idPeriode, $idDivisi)
    {
        $data = $this->getDetailSkorPrivate($idKaryawan, $idPeriode, $idDivisi);
        return $data['total_skor_akhir'];
    }

    private function getDetailSkorPrivate($idKaryawan, $idPeriode, $idDivisiStr)
    {
        // 1. Ambil Header Penilaian
        $header = PenilaianHeader::where('id_karyawan', $idKaryawan)
                                 ->where('id_periode', $idPeriode)
                                 ->first();

        // 2. Ambil Semua Indikator Aktif
        $allIndikators = KategoriKpi::with(['indikators' => function($q) {
            $q->where('status', 'Aktif')->with(['target', 'bobot']);
        }])->where('status', 'Aktif')->get();

        $totalSkorAkhir = 0;
        $detail = [];

        foreach ($allIndikators as $kategori) {
            foreach ($kategori->indikators as $indikator) {
                // Filter Divisi (Penting!)
                $targetsDivisi = $indikator->target_divisi ?? [];
                if (!in_array((string)$idDivisiStr, $targetsDivisi)) continue;

                $nilaiTarget = $indikator->target->nilai_target ?? 0;
                $nilaiBobot = $indikator->bobot->first()->nilai_bobot ?? 0;

                // Hitung Realisasi
                $totalRealisasi = 0;
                if ($header) {
                    $totalRealisasi = PenilaianDetail::where('id_penilaianHeader', $header->id_penilaianHeader)
                                                     ->where('id_indikator', $indikator->id_indikator)
                                                     ->sum('nilai_input');
                }

                // Hitung Capaian
                $pencapaian = ($nilaiTarget > 0) ? ($totalRealisasi / $nilaiTarget) * 100 : 0;
                $skorKontribusi = ($pencapaian * $nilaiBobot) / 100;

                $totalSkorAkhir += $skorKontribusi;
                
                $detail[] = [
                    'kategori' => $kategori->nama_kategori,
                    'indikator' => $indikator->nama_indikator,
                    'satuan' => $indikator->target->jenis_target ?? '-',
                    'target' => $nilaiTarget,
                    'realisasi' => $totalRealisasi,
                    'pencapaian' => $pencapaian,
                    'bobot' => $nilaiBobot,
                    'skor' => $skorKontribusi
                ];
            }
        }

        return ['total_skor_akhir' => $totalSkorAkhir, 'detail' => $detail];
    }
}