<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TargetKpi;
use App\Models\IndikatorKpi;
use App\Models\KategoriKpi;
use App\Models\PenilaianDetail;
use App\Models\Divisi;

class TargetKpiController extends Controller
{
    public function index(Request $request)
    {
        // 1. Query Dasar dengan Eager Loading
        $query = TargetKpi::with(['indikator.kategori']); 

        // 2. Filter Search (Cari berdasarkan Nama Indikator)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('indikator', function($q) use ($search) {
                $q->where('nama_indikator', 'LIKE', "%{$search}%");
            });
        }

        // 3. Filter Divisi (REVISI LOGIC JSON)
        // Kita cari Target yang punya Indikator, dimana kolom target_divisi (JSON) mengandung ID yang dipilih
        if ($request->filled('divisi')) {
            $divisiId = $request->divisi;
            $query->whereHas('indikator', function($q) use ($divisiId) {
                // whereJsonContains sangat cocok untuk format ["1", "2"]
                // Casting ke string karena JSON menyimpan angka sebagai string kadang-kadang
                $q->whereJsonContains('target_divisi', (string)$divisiId);
            });
        }

        // 4. Filter Kategori
        if ($request->filled('kategori')) {
            $kategoriId = $request->kategori;
            $query->whereHas('indikator', function($q) use ($kategoriId) {
                $q->where('id_kategori', $kategoriId);
            });
        }

        // 5. Pagination
        $targets = $query->orderBy('id_target', 'desc')
                         ->paginate(10)
                         ->withQueryString();

        // Data Pendukung Dropdown
        $kategoris = KategoriKpi::orderBy('nama_kategori', 'asc')->get();
        // Hanya ambil divisi aktif untuk filter
        $divisis = Divisi::where('status', true)->orderBy('nama_divisi', 'asc')->get();

        return view('admin.target.index', compact('targets', 'kategoris', 'divisis'));
    }
    
    public function create()
    {
        // Ambil indikator aktif yang belum punya target (Optional: kalau mau 1 indikator = 1 target)
        // Atau ambil semua indikator aktif
        $indikators = IndikatorKpi::where('status', true)->orderBy('nama_indikator', 'asc')->get();
        return view('admin.target.create', compact('indikators'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_indikator' => 'required|exists:indikator_kpis,id_indikator',
            'nilai_target' => 'required|numeric|min:0',
            'jenis_target' => 'required|string|max:50',
        ]);

        TargetKpi::create($request->all());

        return redirect()->route('target.index')->with('success', 'Target KPI berhasil ditambahkan!');
    }

    public function edit(string $id)
    {
        $target = TargetKpi::findOrFail($id);
        $indikators = IndikatorKpi::where('status', true)->orderBy('nama_indikator', 'asc')->get();

        return view('admin.target.edit', compact('target', 'indikators'));
    }

    public function update(Request $request, string $id)
    {
        $target = TargetKpi::findOrFail($id);

        $request->validate([
            'id_indikator' => 'required|exists:indikator_kpis,id_indikator',
            'nilai_target' => 'required|numeric|min:0',
            'jenis_target' => 'required|string|max:50',
        ]);

        $target->update($request->all());

        return redirect()->route('target.index')->with('success', 'Target KPI berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     * Menggunakan Soft Delete logic (di view pakai modal)
     */
    public function destroy(string $id)
    {
        $target = TargetKpi::findOrFail($id);
        
        $isUsed = PenilaianDetail::where('id_indikator', $target->id_indikator)->exists();
        if ($isUsed) {
            return redirect()->back()->with('error', 'Gagal Menghapus! Target ini tidak bisa dihapus karena sudah digunakan dalam perhitungan Realisasi/Penilaian karyawan. Menghapusnya akan merusak skor laporan.');
        }
        
        $target->delete();

        return redirect()->route('target.index')->with('success', 'Target KPI berhasil dihapus!');
    }
}