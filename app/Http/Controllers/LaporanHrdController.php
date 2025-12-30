<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karyawan;
use App\Models\Divisi;
use App\Models\PeriodeEvaluasi;
use App\Models\PenilaianHeader;
use App\Models\PenilaianDetail;
use App\Models\KategoriKpi;
use Illuminate\Pagination\LengthAwarePaginator;

class LaporanHrdController extends Controller
{
    /**
     * Dashboard Monitoring Semua Karyawan
     */
    public function index(Request $request)
    {
        // 1. Filter Dropdown (Ambil divisi aktif - boolean true)
        $divisis = Divisi::where('status', true)->get();
        $periodes = PeriodeEvaluasi::all();
        
        // Default: Periode Aktif (boolean true)
        $periodeAktif = PeriodeEvaluasi::where('status', true)->first();
        $selectedPeriode = $request->id_periode ?? ($periodeAktif ? $periodeAktif->id_periode : null);
        $selectedDivisi = $request->id_divisi ?? null;

        // 2. Query Dasar Karyawan Aktif
        $query = Karyawan::with('divisi')->where('status', true);

        // --- FILTER KHUSUS ROLE 'KARYAWAN' ---
        // (Sama seperti logic Ranking: Exclude Manajer & HRD)
        $query->whereHas('user', function($q) {
            $q->where('role', 'Karyawan'); 
        });
        // -------------------------------------

        // Filter Divisi
        if ($selectedDivisi) {
            $query->where('id_divisi', $selectedDivisi);
        }

        // Logika Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_lengkap', 'LIKE', "%{$search}%")
                  ->orWhere('nik', 'LIKE', "%{$search}%");
            });
        }

        // 3. Pagination & Execution
        $karyawans = $query->orderBy('nama_lengkap', 'asc')
                           ->paginate(10)
                           ->withQueryString();

        // 4. Hitung Skor Real-time untuk setiap karyawan (Hanya yang di halaman ini)
        foreach ($karyawans as $karyawan) {
            if ($selectedPeriode) {
                $karyawan->skor_saat_ini = $this->hitungSkor($karyawan->id_karyawan, $selectedPeriode, $karyawan->id_divisi);
            } else {
                $karyawan->skor_saat_ini = 0;
            }
        }

        return view('admin.laporan.index', compact('karyawans', 'divisis', 'periodes', 'selectedPeriode', 'selectedDivisi'));
    }
    
    public function show($id_karyawan, $id_periode)
    {
        $karyawan = Karyawan::findOrFail($id_karyawan);
        $periode = PeriodeEvaluasi::findOrFail($id_periode);
        
        $dataRapor = $this->getDetailSkor($id_karyawan, $id_periode, $karyawan->id_divisi);

        return view('admin.laporan.show', compact('karyawan', 'periode', 'dataRapor'));
    }

    private function hitungSkor($idKaryawan, $idPeriode, $idDivisi)
    {
        $data = $this->getDetailSkor($idKaryawan, $idPeriode, $idDivisi);
        return $data['total_skor_akhir'];
    }

    private function getDetailSkor($idKaryawan, $idPeriode, $idDivisiStr)
    {
        $header = PenilaianHeader::where('id_karyawan', $idKaryawan)
                                 ->where('id_periode', $idPeriode)
                                 ->first();

        // Ambil Indikator Aktif (boolean true)
        $allIndikators = KategoriKpi::with(['indikators' => function($q) {
            $q->where('status', true)->with(['target', 'bobot']);
        }])->where('status', true)->get();

        $totalSkorAkhir = 0;
        $detail = [];

        foreach ($allIndikators as $kategori) {
            foreach ($kategori->indikators as $indikator) {
                $targetsDivisi = $indikator->target_divisi ?? [];
                if (!in_array((string)$idDivisiStr, $targetsDivisi)) continue;

                $nilaiTarget = $indikator->target->nilai_target ?? 0;
                $nilaiBobot = $indikator->bobot->first()->nilai_bobot ?? 0;

                $totalRealisasi = 0;
                if ($header) {
                    $totalRealisasi = PenilaianDetail::where('id_penilaianHeader', $header->id_penilaianHeader)
                                                     ->where('id_indikator', $indikator->id_indikator)
                                                     ->sum('nilai_input');
                }

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
     * HALAMAN RANKING (PERBANDINGAN) DENGAN PAGINATION
     */
    public function ranking(Request $request)
    {
        $periodes = PeriodeEvaluasi::all();
        $divisis = Divisi::where('status', true)->get();

        $periodeAktif = PeriodeEvaluasi::where('status', true)->first();
        $selectedPeriode = $request->id_periode ?? ($periodeAktif ? $periodeAktif->id_periode : null);
        $selectedDivisi = $request->id_divisi ?? null;

        // Query Dasar Karyawan Aktif
        $query = Karyawan::with('divisi')->where('status', true);

        // Filter Role Karyawan Only
        $query->whereHas('user', function($q) {
            $q->where('role', 'Karyawan'); 
        });

        if ($selectedDivisi) {
            $query->where('id_divisi', $selectedDivisi);
        }

        $karyawans = $query->get();

        // Hitung Skor & Mapping Data
        $rankingCollection = $karyawans->map(function($karyawan) use ($selectedPeriode) {
            $skor = $selectedPeriode ? $this->hitungSkor($karyawan->id_karyawan, $selectedPeriode, $karyawan->id_divisi) : 0;
            
            // LOGIKA GRADE BARU (SS, S, A, B, C, D, E)
            $grade = 'E';
            
            if ($skor > 120) {
                $grade = 'SS';
            } elseif ($skor >= 100) {
                $grade = 'S';
            } elseif ($skor >= 90) {
                $grade = 'A';
            } elseif ($skor >= 80) {
                $grade = 'B';
            } elseif ($skor >= 70) {
                $grade = 'C';
            } elseif ($skor >= 60) {
                $grade = 'D';
            } else {
                $grade = 'E';
            }

            return [
                'nama' => $karyawan->nama_lengkap,
                'foto' => $karyawan->foto, // Pastikan foto terambil
                'nik' => $karyawan->nik,
                'divisi' => $karyawan->divisi->nama_divisi ?? '-',
                'skor' => $skor,
                'grade' => $grade
            ];
        });

        // Urutkan dari Skor Tertinggi
        $sortedRanking = $rankingCollection->sortByDesc('skor')->values();

        // --- MANUAL PAGINATION ---
        $perPage = 10; 
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentItems = $sortedRanking->slice(($currentPage - 1) * $perPage, $perPage)->all();

        $ranking = new LengthAwarePaginator($currentItems, $sortedRanking->count(), $perPage, $currentPage, [
            'path' => LengthAwarePaginator::resolveCurrentPath(),
            'query' => $request->query(),
        ]);

        return view('admin.laporan.ranking', compact('ranking', 'periodes', 'divisis', 'selectedPeriode', 'selectedDivisi'));
    }
}