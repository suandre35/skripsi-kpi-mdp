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
use Carbon\Carbon;

class PenilaianController extends Controller
{
    /**
     * Tampilkan Riwayat Log (Tanpa Filter ribet, cuma log user login)
     */
    public function index()
    {
        $logs = PenilaianDetail::with(['header.karyawan', 'indikator.target'])
                    ->whereHas('header', function($q) {
                        $q->where('id_penilai', Auth::id());
                    })
                    ->orderBy('created_at', 'desc')
                    ->paginate(20);

        // --- TAMBAHAN LOGIC UX ---
        // Cek apakah tombol input harus dinyalakan atau dimatikan
        $periode = PeriodeEvaluasi::where('status', true)->first(); // Pakai boolean true
        $isInputOpen = false;
        $periodePesan = '';

        if ($periode) {
            $sekarang = Carbon::now();
            if ($sekarang->lt($periode->tanggal_mulai)) {
                $periodePesan = 'Periode evaluasi belum dimulai. (Mulai: ' . $periode->tanggal_mulai->format('d M Y') . ')';
            } elseif ($sekarang->gt($periode->tanggal_selesai)) {
                $periodePesan = 'Periode evaluasi telah berakhir pada ' . $periode->tanggal_selesai->format('d M Y H:i');
            } else {
                $isInputOpen = true; // Waktu valid
            }
        } else {
            $periodePesan = 'Tidak ada periode evaluasi yang aktif saat ini.';
        }

        return view('manajer.penilaian.index', compact('logs', 'isInputOpen', 'periodePesan'));
    }

    /**
     * Form Input Log Harian
     */
    public function create()
    {
        $userLogin = Auth::user();

        // 1. Cek Divisi Manajer
        $divisiDipimpin = Divisi::where('id_manajer', $userLogin->id_user)->where('status', true)->first();
        if (!$divisiDipimpin) {
            return redirect()->route('dashboard')->with('error', 'Akses Ditolak! Anda bukan Kepala Divisi.');
        }

        // 2. Cek Periode & Waktu (PERBAIKAN DISINI)
        // Agar kalau dipaksa masuk URL, dia nendang balik ke index penilaian, bukan dashboard
        $periodeAktif = PeriodeEvaluasi::where('status', true)->first();
        
        if (!$periodeAktif) {
            return redirect()->route('penilaian.index')->with('error', 'Akses ditutup. Tidak ada periode aktif.');
        }

        $sekarang = Carbon::now();
        if ($sekarang->lt($periodeAktif->tanggal_mulai) || $sekarang->gt($periodeAktif->tanggal_selesai)) {
            return redirect()->route('penilaian.index')->with('error', 'Saat ini bukan waktu penginputan penilaian.');
        }

        // 3. Ambil Karyawan (Satu Divisi)
        // Pastikan status karyawan juga dicek pake boolean true jika migrasi sudah update
        $karyawans = Karyawan::where('status', true) 
                             ->where('id_divisi', $divisiDipimpin->id_divisi)
                             ->where('id_user', '!=', $userLogin->id_user)
                             ->get();

        // 4. Ambil Struktur KPI Sesuai Divisi
        $myDivisiId = (string) $divisiDipimpin->id_divisi;
        $kategoris = KategoriKpi::with(['indikators' => function($query) {
            $query->where('status', true)->with('target'); 
        }])->where('status', true)->get();

        // Filter Indikator
        $kategoris = $kategoris->map(function ($kategori) use ($myDivisiId) {
            $filteredIndikators = $kategori->indikators->filter(function ($indikator) use ($myDivisiId) {
                $targets = $indikator->target_divisi ?? [];
                // Pastikan target_divisi dicasting ke array jika null (safety)
                return is_array($targets) && in_array($myDivisiId, $targets);
            });
            $kategori->setRelation('indikators', $filteredIndikators);
            return $kategori;
        })->filter(fn($k) => $k->indikators->isNotEmpty());

        return view('manajer.penilaian.create', compact('periodeAktif', 'karyawans', 'kategoris'));
    }

    /**
     * Simpan Log (TANPA TANGGAL MANUAL)
     */
    public function store(Request $request)
    {
        // ... (Isi sama seperti sebelumnya, tidak ada perubahan logika waktu disini) ...
        // Kode store Anda yang lama sudah aman.
        $request->validate([
            'id_karyawan' => 'required|exists:karyawans,id_karyawan',
            'id_periode'  => 'required|exists:periode_evaluasis,id_periode',
            'aktivitas.*.nilai' => 'nullable|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
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
                return redirect()->back()->with('error', 'Isi minimal satu nilai.');
            }

            $header = PenilaianHeader::firstOrCreate(
                [
                    'id_karyawan' => $request->id_karyawan,
                    'id_periode'  => $request->id_periode,
                ],
                [
                    'id_penilai'  => Auth::id(),
                ]
            );

            foreach ($request->aktivitas as $id_indikator => $data) {
                if (isset($data['nilai']) && $data['nilai'] !== null && $data['nilai'] !== '') {
                    PenilaianDetail::create([
                        'id_penilaianHeader' => $header->id_penilaianHeader,
                        'id_indikator'       => $id_indikator,
                        'nilai_input'        => $data['nilai'],
                        'catatan'            => $data['catatan'] ?? null,
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('penilaian.index')->with('success', 'Berhasil disimpan!');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Edit Log
     */ 
    public function edit($id)
    {
        $log = PenilaianDetail::with(['header.karyawan', 'indikator.target'])->findOrFail($id);
        if ($log->header->id_penilai != Auth::id()) return redirect()->route('penilaian.index')->with('error', 'Akses ditolak.');
        return view('manajer.penilaian.edit', compact('log'));
    }

    /**
     * Update Log
     */
    public function update(Request $request, $id)
    {
        $request->validate(['nilai_input' => 'required|numeric|min:0', 'catatan' => 'nullable|string|max:255']);
        try {
            $log = PenilaianDetail::findOrFail($id);
            $log->update(['nilai_input' => $request->nilai_input, 'catatan' => $request->catatan]);
            return redirect()->route('penilaian.index')->with('success', 'Diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal update.');
        }
    }

    /**
     * Hapus Log
     */
    public function destroy($id)
    {
        $log = PenilaianDetail::findOrFail($id);
        if ($log->header->id_penilai != Auth::id()) abort(403);
        $log->delete();
        return redirect()->back()->with('success', 'Dihapus.');
    }

    // ----------------------------------------------------------------------
    //  METHOD YANG HILANG (UNTUK LAPORAN RAPOR TIM)
    // ----------------------------------------------------------------------

    /**
     * Halaman Rapor Kinerja Tim (Khusus Manajer)
     */
    public function laporan(Request $request)
    {
        $user = Auth::user();
        $manajer = Karyawan::with('divisi')->where('id_user', $user->id_user)->first();

        if (!$manajer) {
            return redirect()->route('dashboard')->with('error', 'Profil Manajer belum ditemukan!');
        }

        $periodes = PeriodeEvaluasi::all();
        // PERBAIKAN: status -> true
        $periodeAktif = PeriodeEvaluasi::where('status', true)->first();
        $selectedPeriode = $request->id_periode ?? ($periodeAktif ? $periodeAktif->id_periode : null);

        $query = Karyawan::where('id_divisi', $manajer->id_divisi)
                         // PERBAIKAN FATAL DISINI: status_karyawan='Aktif' -> status=true
                         ->where('status', true)
                         ->where('id_karyawan', '!=', $manajer->id_karyawan); 

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_lengkap', 'LIKE', "%{$search}%")
                  ->orWhere('nik', 'LIKE', "%{$search}%");
            });
        }

        $karyawans = $query->get();

        foreach ($karyawans as $k) {
            if ($selectedPeriode) {
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
        $user = Auth::user();
        $manajer = Karyawan::where('id_user', $user->id_user)->first();
        
        if($manajer->id_divisi != $karyawan->id_divisi){
            abort(403, 'Anda tidak berhak melihat rapor divisi lain.');
        }

        // PERBAIKAN: status -> true
        $periode = PeriodeEvaluasi::where('status', true)->first();
        
        if(!$periode) {
            return redirect()->back()->with('error', 'Tidak ada periode aktif.');
        }

        $dataRapor = $this->getDetailSkorPrivate($id_karyawan, $periode->id_periode, $karyawan->id_divisi);

        return view('manajer.penilaian.detail', compact('karyawan', 'periode', 'dataRapor'));
    }

    // --- HELPER FUNCTION (Logic Hitung Skor) ---
    
    private function hitungSkorPrivate($idKaryawan, $idPeriode, $idDivisi)
    {
        $data = $this->getDetailSkorPrivate($idKaryawan, $idPeriode, $idDivisi);
        return $data['total_skor_akhir'];
    }

    private function getDetailSkorPrivate($idKaryawan, $idPeriode, $idDivisiStr)
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