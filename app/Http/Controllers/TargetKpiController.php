<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TargetKpi;
use App\Models\IndikatorKpi;
use App\Models\KategoriKpi;
use App\Models\Divisi; // Import Model Divisi

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
                // whereJsonContains sangat cocok untuk format ["1", "2"] seperti di screenshot
                $q->whereJsonContains('target_divisi', $divisiId);
            });
        }

        // 4. Filter Kategori
        if ($request->filled('kategori')) {
            $kategoriId = $request->kategori;
            $query->whereHas('indikator', function($q) use ($kategoriId) {
                $q->where('id_kategori', $kategoriId);
            });
        }

        // 5. Filter Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // 6. Pagination
        $targets = $query->orderBy('id_target', 'desc')
                         ->paginate(10)
                         ->withQueryString();

        // Data Pendukung Dropdown
        $kategoris = KategoriKpi::orderBy('nama_kategori', 'asc')->get();
        $divisis = Divisi::where('status', 'Aktif')->orderBy('nama_divisi', 'asc')->get();

        return view('admin.target.index', compact('targets', 'kategoris', 'divisis'));
    }

    // ... method create, store, edit, update, destroy TETAP SAMA ...
    
    public function create()
    {
        $indikators = IndikatorKpi::where('status', 'Aktif')->get();
        return view('admin.target.create', compact('indikators'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_indikator' => 'required|exists:indikator_kpis,id_indikator',
            'nilai_target' => 'required|string|max:100',
            'jenis_target' => 'nullable|string|max:50',
        ]);

        $data = $request->all();
        $data['status'] = 'Aktif';

        TargetKpi::create($data);

        return redirect()->route('target.index')->with('success', 'Target KPI berhasil ditambahkan!');
    }

    public function edit(string $id)
    {
        $target = TargetKpi::findOrFail($id);
        $indikators = IndikatorKpi::where('status', 'Aktif')->get();
        return view('admin.target.edit', compact('target', 'indikators'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'id_indikator' => 'required|exists:indikator_kpis,id_indikator',
            'nilai_target' => 'required|string|max:100',
            'jenis_target' => 'nullable|string|max:50',
            'status'       => ['required', 'in:Aktif,Nonaktif'],
        ]);

        $target = TargetKpi::findOrFail($id);
        $target->update($request->all());

        return redirect()->route('target.index')->with('success', 'Target KPI berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $target = TargetKpi::findOrFail($id);
        $target->delete();

        return redirect()->route('target.index')->with('success', 'Target KPI berhasil dihapus!');
    }
}