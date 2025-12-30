<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Karyawan;
use App\Models\PeriodeEvaluasi;
use App\Models\PenilaianHeader;
use App\Models\PenilaianDetail;
use App\Models\KategoriKpi;

class KaryawanPanelController extends Controller
{
    public function index()
    {
        // 1. Cari Data Karyawan
        $user = Auth::user();
        $karyawan = Karyawan::with('divisi')->where('id_user', $user->id_user)->first();

        if (!$karyawan) {
            return redirect()->route('dashboard')->with('error', 'Data Karyawan tidak ditemukan.');
        }

        // 2. Ambil Periode Aktif
        $periode = PeriodeEvaluasi::where('status', true)->first();
        
        // 3. LOGIKA BARU (PERBAIKAN): Cek Akses Rapor dari kolom 'pengumuman'
        // pengumuman == 1 (True) -> Buka
        // pengumuman == 0 (False) -> Tutup
        $isRaporOpen = $periode && $periode->pengumuman == true;

        $dataRapor = [
            'total_skor_akhir' => 0,
            'detail' => []
        ];

        // 4. Hitung Skor HANYA JIKA Akses Dibuka
        if ($isRaporOpen) {
            $dataRapor = $this->getDetailSkor($karyawan->id_karyawan, $periode->id_periode, $karyawan->id_divisi);
        }

        return view('karyawan.index', compact('karyawan', 'periode', 'dataRapor', 'isRaporOpen'));
    }

    // --- HELPER FUNCTION ---
    private function getDetailSkor($idKaryawan, $idPeriode, $idDivisiStr)
    {
        $header = PenilaianHeader::where('id_karyawan', $idKaryawan)
                                 ->where('id_periode', $idPeriode)
                                 ->first();

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
}