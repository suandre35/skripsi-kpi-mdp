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
        // 1. Cari Data Karyawan berdasarkan User yang Login
        $user = Auth::user();
        $karyawan = Karyawan::with('divisi')->where('id_user', $user->id_user)->first();

        // Jika user login bukan karyawan (misal admin iseng login pakai role karyawan), cegah error
        if (!$karyawan) {
            return redirect()->route('dashboard')->with('error', 'Data Karyawan tidak ditemukan.');
        }

        // 2. Ambil Periode Aktif (PERBAIKAN: status -> true)
        $periode = PeriodeEvaluasi::where('status', true)->first();
        
        // 3. Hitung Skor (Jika ada periode aktif)
        $dataRapor = [
            'total_skor_akhir' => 0,
            'detail' => []
        ];

        if ($periode) {
            $dataRapor = $this->getDetailSkor($karyawan->id_karyawan, $periode->id_periode, $karyawan->id_divisi);
        }

        return view('karyawan.index', compact('karyawan', 'periode', 'dataRapor'));
    }

    // --- HELPER FUNCTION (Logic Hitungan SAMA PERSIS dengan Manajer) ---
    private function getDetailSkor($idKaryawan, $idPeriode, $idDivisiStr)
    {
        $header = PenilaianHeader::where('id_karyawan', $idKaryawan)
                                 ->where('id_periode', $idPeriode)
                                 ->first();

        // PERBAIKAN: status -> true
        $allIndikators = KategoriKpi::with(['indikators' => function($q) {
            $q->where('status', true)->with(['target', 'bobot']);
        }])->where('status', true)->get();

        $totalSkorAkhir = 0;
        $detail = [];

        foreach ($allIndikators as $kategori) {
            foreach ($kategori->indikators as $indikator) {
                // Filter Divisi
                $targetsDivisi = $indikator->target_divisi ?? [];
                // Pastikan tipe data sama (string vs int)
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