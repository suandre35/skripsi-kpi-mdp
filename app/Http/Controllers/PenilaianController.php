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

class PenilaianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $penilaians = PenilaianHeader::with(['karyawan', 'periode', 'penilai'])->get();
        return view('admin.penilaian.index', compact('penilaians'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // 1. Cek Periode Aktif
        $periodeAktif = PeriodeEvaluasi::where('status', 'Aktif')->first();

        if (!$periodeAktif) {
            return redirect()->route('penilaian.index')->with('error', 'Tidak ada Periode Evaluasi yang sedang Aktif!');
        }

        // 2. Filter Karyawan yang BELUM dinilai di periode ini
        $sudahDinilai = PenilaianHeader::where('id_periode', $periodeAktif->id_periode)
                                       ->pluck('id_karyawan');
        
        $karyawans = Karyawan::where('status_karyawan', 'Aktif')
                             ->whereNotIn('id_karyawan', $sudahDinilai)
                             ->get();

        // 3. Ambil Struktur KPI
        $kategoris = KategoriKpi::with(['indikators' => function($query) {
            $query->where('status', 'Aktif')->with('bobot'); // Asumsi relasi indikator ke bobot bernama 'bobot'
        }])->where('status', 'Aktif')->get();

        return view('admin.penilaian.create', compact('periodeAktif', 'karyawans', 'kategoris'));
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
                $bobotVal = DB::table('bobot_kpis')
                              ->where('id_indikator', $id_indikator)
                              ->where('status', 'Aktif')
                              ->value('nilai_bobot') ?? 0;
                
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
                    'id_penilaianHeader' => $header->id_penilaianHeader, // PK Baru
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
        $penilaian = PenilaianHeader::with('details')->findOrFail($id);
        
        $kategoris = KategoriKpi::with(['indikators' => function($query) {
            $query->with('bobot');
        }])->get();

        // Mapping nilai lama: [id_indikator => nilai_input]
        $nilaiLama = $penilaian->details->pluck('nilai_input', 'id_indikator')->toArray();

        return view('admin.penilaian.edit', compact('penilaian', 'kategoris', 'nilaiLama'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $header = PenilaianHeader::findOrFail($id);

        $request->validate([
            'nilai'   => 'required|array',
            'nilai.*' => 'required|numeric|min:0|max:100',
        ]);

        DB::beginTransaction();

        try {
            // 1. Hitung Ulang Total
            $grandTotal = 0;
            foreach ($request->nilai as $id_indikator => $nilaiInput) {
                $bobotVal = DB::table('bobot_kpis')
                              ->where('id_indikator', $id_indikator)
                              ->where('status', 'Aktif')
                              ->value('nilai_bobot') ?? 0;
                
                $grandTotal += ($nilaiInput * $bobotVal) / 100;
            }

            // 2. Update Header
            $header->update([
                'total_nilai' => $grandTotal,
                // tanggal_penilaian mau diupdate ke hari ini atau tetap tgl lama? 
                // Opsional: 'tanggal_penilaian' => now(), 
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
        //
    }
}
