<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karyawan;
use App\Models\Divisi;
use App\Models\PeriodeEvaluasi;
use App\Models\PenilaianHeader;
use App\Models\PenilaianDetail;
use App\Models\KategoriKpi;

class LaporanHrdController extends Controller
{
    /**
     * Dashboard Monitoring Semua Karyawan
     */
    public function index(Request $request)
    {
        // 1. Filter Dropdown
        $divisis = Divisi::where('status', 'Aktif')->get();
        $periodes = PeriodeEvaluasi::all();
        
        // Default: Periode Aktif
        $periodeAktif = PeriodeEvaluasi::where('status', 'Aktif')->first();
        $selectedPeriode = $request->id_periode ?? ($periodeAktif ? $periodeAktif->id_periode : null);
        $selectedDivisi = $request->id_divisi ?? null;

        // 2. Query Karyawan (Sesuai Filter)
        $query = Karyawan::with('divisi')->where('status_karyawan', 'Aktif');

        if ($selectedDivisi) {
            $query->where('id_divisi', $selectedDivisi);
        }

        // Kecuali Admin/HRD sendiri (opsional)
        // $query->where('role', '!=', 'HRD'); 

        $karyawans = $query->get();

        // 3. Hitung Skor Real-time untuk setiap karyawan
        foreach ($karyawans as $karyawan) {
            if ($selectedPeriode) {
                $karyawan->skor_saat_ini = $this->hitungSkor($karyawan->id_karyawan, $selectedPeriode, $karyawan->id_divisi);
            } else {
                $karyawan->skor_saat_ini = 0;
            }
        }

        return view('admin.laporan.index', compact('karyawans', 'divisis', 'periodes', 'selectedPeriode', 'selectedDivisi'));
    }

    /**
     * Detail Rapor Karyawan (View HRD)
     */
    public function show($id_karyawan, $id_periode)
    {
        $karyawan = Karyawan::findOrFail($id_karyawan);
        $periode = PeriodeEvaluasi::findOrFail($id_periode);
        
        $dataRapor = $this->getDetailSkor($id_karyawan, $id_periode, $karyawan->id_divisi);

        return view('admin.laporan.show', compact('karyawan', 'periode', 'dataRapor'));
    }

    // --- HELPER FUNCTION (Logic kalkulasi sama dengan Manajer) ---
    private function hitungSkor($idKaryawan, $idPeriode, $idDivisi)
    {
        $data = $this->getDetailSkor($idKaryawan, $idPeriode, $idDivisi);
        return $data['total_skor_akhir'];
    }

    private function getDetailSkor($idKaryawan, $idPeriode, $idDivisiStr)
    {
        // Ambil Header
        $header = PenilaianHeader::where('id_karyawan', $idKaryawan)
                                 ->where('id_periode', $idPeriode)
                                 ->first();

        // Ambil Indikator Global
        $allIndikators = KategoriKpi::with(['indikators' => function($q) {
            $q->where('status', 'Aktif')->with(['target', 'bobot']);
        }])->where('status', 'Aktif')->get();

        $totalSkorAkhir = 0;
        $detail = [];

        foreach ($allIndikators as $kategori) {
            foreach ($kategori->indikators as $indikator) {
                // Filter Divisi
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

    /**
     * Laporan Perbandingan Kinerja (Ranking)
     */
    public function ranking(Request $request)
    {
        // 1. Ambil Periode (Default: Aktif)
        $periodes = PeriodeEvaluasi::all();
        $periodeAktif = PeriodeEvaluasi::where('status', 'Aktif')->first();
        $selectedPeriode = $request->id_periode ?? ($periodeAktif ? $periodeAktif->id_periode : null);

        // 2. Ambil Semua Karyawan
        $karyawans = Karyawan::with('divisi')->where('status_karyawan', 'Aktif')->get();

        // 3. Hitung Skor & Masukkan ke Collection
        $ranking = $karyawans->map(function($karyawan) use ($selectedPeriode) {
            $skor = $selectedPeriode ? $this->hitungSkor($karyawan->id_karyawan, $selectedPeriode, $karyawan->id_divisi) : 0;
            return [
                'nama' => $karyawan->nama_lengkap,
                'divisi' => $karyawan->divisi->nama_divisi,
                'skor' => $skor,
                // Tentukan Grade
                'grade' => $skor >= 90 ? 'A' : ($skor >= 80 ? 'B' : ($skor >= 70 ? 'C' : ($skor >= 60 ? 'D' : 'E')))
            ];
        });

        // 4. Urutkan dari Skor Tertinggi (Desc)
        $ranking = $ranking->sortByDesc('skor')->values();

        return view('admin.laporan.ranking', compact('ranking', 'periodes', 'selectedPeriode'));
    }
}