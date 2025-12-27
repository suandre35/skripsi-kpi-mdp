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
     * Display a listing of the resource.
     */
    public function index()
    {
        // Tampilkan hanya penilaian yang dibuat oleh Manajer yang sedang login
        $penilaians = PenilaianHeader::with(['karyawan', 'periode', 'penilai'])->where('id_penilai', Auth::id()) ->orderBy('created_at', 'desc')->get();

        // View diarahkan ke folder manajer/penilaian
        return view('manajer.penilaian.index', compact('penilaians'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $userLogin = Auth::user();

        // 1. VALIDASI: Pastikan User adalah Kepala Divisi
        // Cari Divisi dimana id_manajer = id user yang login
        $divisiDipimpin = Divisi::where('id_manajer', $userLogin->id_user)->where('status', 'Aktif')->first();

        if (!$divisiDipimpin) {
            // Jika dia Role Manajer tapi belum diset di tabel Divisi sebagai kepala
            return redirect()->route('dashboard')->with('error', 'Akses Ditolak! Anda belum terdaftar sebagai Kepala Divisi manapun.');
        }

        // 2. Cek Periode Aktif
        $periodeAktif = PeriodeEvaluasi::where('status', 'Aktif')->first();

        if (!$periodeAktif) {
            return redirect()->route('penilaian.index')->with('error', 'Tidak ada Periode Evaluasi yang sedang Aktif!');
        }

        // 3. Filter Karyawan
        // - Harus Karyawan Aktif
        // - Harus bawahan divisi Manajer ini
        // - Belum dinilai pada periode ini
        // - Bukan dirinya sendiri (opsional, manajer tidak menilai diri sendiri di form ini)
        
        $sudahDinilai = PenilaianHeader::where('id_periode', $periodeAktif->id_periode)->pluck('id_karyawan');
        
        $karyawans = Karyawan::where('status_karyawan', 'Aktif')->where('id_divisi', $divisiDipimpin->id_divisi)->whereNotIn('id_karyawan', $sudahDinilai)->where('id_user', '!=', $userLogin->id_user)->get();

        // 4. Ambil Struktur KPI
        // Ambil semua kategori & indikator aktif beserta bobotnya
        $allKategoris = KategoriKpi::with(['indikators' => function($query) {
            $query->where('status', 'Aktif')->with(['bobot' => function($q) {
                $q->where('status', 'Aktif');
            }]);
        }])->where('status', 'Aktif')->get();

        // 5. LOGIKA FILTER INDIKATOR BERDASARKAN DIVISI (INTI SOLUSI)
        // ID Divisi Manajer sebagai kunci filter
        $myDivisiId = $divisiDipimpin->id_divisi;

        // Clone variabel agar aman
        $kategoris = $allKategoris->map(function ($kategori) use ($myDivisiId) {
            
            // Filter koleksi indikator di dalam kategori ini
            $filteredIndikators = $kategori->indikators->filter(function ($indikator) use ($myDivisiId) {
                
                // Ambil array target_divisi (otomatis jadi array karena $casts di Model)
                // Jika kosong/null, kita anggap array kosong []
                $targets = $indikator->target_divisi ?? [];

                // Cek: Apakah ID Divisi Manajer ada di dalam daftar target?
                // Ingat: Array dari DB mungkin string ("5"), jadi in_array aman.
                return in_array($myDivisiId, $targets);
            });

            // Set ulang relasi indikator dengan hasil filter
            $kategori->setRelation('indikators', $filteredIndikators);
            
            return $kategori;
        });

        // 6. BERSIHKAN KATEGORI KOSONG
        // Jika setelah difilter kategori A tidak punya indikator sama sekali, hapus kategori A dari tampilan
        $kategoris = $kategoris->filter(function ($kategori) {
            return $kategori->indikators->isNotEmpty();
        });

        return view('manajer.penilaian.create', compact('periodeAktif', 'karyawans', 'kategoris', 'divisiDipimpin'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_karyawan' => 'required|exists:karyawans,id_karyawan',
            'id_periode'  => 'required|exists:periode_evaluasis,id_periode',
            'nilai'       => 'required|array',       // Array Input Nilai
            'nilai.*'     => 'required|numeric|min:0|max:100',
        ]);

        DB::beginTransaction();

        try {
            // 1. Hitung Total Nilai
            $grandTotal = 0;

            // Loop input dari form untuk hitung skor backend
            foreach ($request->nilai as $id_indikator => $nilaiInput) {
                // Ambil bobot dari tabel bobot_kpis
                $bobotVal = DB::table('bobot_kpis')->where('id_indikator', $id_indikator)->where('status', 'Aktif')->value('nilai_bobot') ?? 0;
                
                // Rumus: (Input * Bobot) / 100
                $skor = ($nilaiInput * $bobotVal) / 100;
                $grandTotal += $skor;
            }

            // 2. Simpan Header
            $header = PenilaianHeader::create([
                'id_karyawan'       => $request->id_karyawan,
                'id_periode'        => $request->id_periode,
                'id_penilai'        => Auth::id(), // User Login
                'tanggal_penilaian' => now(),
                'total_nilai'       => $grandTotal,
            ]);

            // 3. Simpan Detail
            foreach ($request->nilai as $id_indikator => $nilaiInput) {
                PenilaianDetail::create([
                    'id_penilaianHeader' => $header->id_penilaianHeader, // PK Baru sesuai model
                    'id_indikator'       => $id_indikator,
                    'nilai_input'        => $nilaiInput,
                ]);
            }

            DB::commit();
            return redirect()->route('penilaian.index')->with('success', 'Penilaian berhasil disimpan! Skor Akhir: ' . $grandTotal);

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Pastikan manajer hanya bisa edit penilaian buatannya sendiri (Opsional keamanan tambahan)
        $penilaian = PenilaianHeader::with('details')->where('id_penilai', Auth::id())->findOrFail($id);
        
        $kategoris = KategoriKpi::with(['indikators' => function($query) {
            $query->with(['bobot' => function($q) { $q->where('status', 'Aktif'); }]);
        }])->where('status', 'Aktif')->get();

        // Mapping nilai lama: [id_indikator => nilai_input]
        $nilaiLama = $penilaian->details->pluck('nilai_input', 'id_indikator')->toArray();

        // Agar jika HRD mengubah struktur divisi di tengah jalan, edit nilai lama tidak rusak/hilang
        $kategoris = $kategoris->map(function($kategori) use ($nilaiLama) {
            $filteredIndikators = $kategori->indikators->filter(function($indikator) use ($nilaiLama) {
                // Hanya tampilkan indikator yang SUDAH PERNAH dinilai di data ini
                return array_key_exists($indikator->id_indikator, $nilaiLama);
            });
            $kategori->setRelation('indikators', $filteredIndikators);
            return $kategori;
        })->filter(fn($k) => $k->indikators->isNotEmpty());

        // View diarahkan ke folder manajer/penilaian
        return view('manajer.penilaian.edit', compact('penilaian', 'kategoris', 'nilaiLama'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $header = PenilaianHeader::findOrFail($id);

        // Pastikan yang update adalah pemilik penilaian
        if ($header->id_penilai != Auth::id()) {
            abort(403, 'Anda tidak berhak mengedit penilaian ini.');
        }

        $request->validate([
            'nilai'   => 'required|array',
            'nilai.*' => 'required|numeric|min:0|max:100',
        ]);

        DB::beginTransaction();

        try {
            // 1. Hitung Ulang Total
            $grandTotal = 0;
            foreach ($request->nilai as $id_indikator => $nilaiInput) {
                $bobotVal = DB::table('bobot_kpis')->where('id_indikator', $id_indikator)->where('status', 'Aktif')->value('nilai_bobot') ?? 0;
                
                $grandTotal += ($nilaiInput * $bobotVal) / 100;
            }

            // 2. Update Header
            $header->update([
                'total_nilai' => $grandTotal,
                'updated_at'  => now(),
            ]);

            // 3. Update Detail
            foreach ($request->nilai as $id_indikator => $nilaiInput) {
                PenilaianDetail::updateOrCreate(
                    [
                        'id_penilaianHeader' => $header->id_penilaianHeader,
                        'id_indikator'       => $id_indikator
                    ],
                    [
                        'nilai_input' => $nilaiInput
                    ]
                );
            }

            DB::commit();
            return redirect()->route('penilaian.index')->with('success', 'Penilaian diperbarui! Skor Baru: ' . $grandTotal);

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return redirect()->back()->with('error', 'Data penilaian tidak dapat dihapus (Arsip Tetap).');
    }
}