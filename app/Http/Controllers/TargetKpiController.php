<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TargetKpi;
use App\Models\IndikatorKpi;
use App\Models\KategoriKpi; 

class TargetKpiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // 1. Query Dasar dengan Eager Loading
        // Kita tambah '.kategori' agar bisa ambil nama kategori lewat indikator
        $query = TargetKpi::with(['indikator.kategori']);

        // 2. Filter Search (Cari berdasarkan Nama Indikator)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('indikator', function($q) use ($search) {
                $q->where('nama_indikator', 'LIKE', "%{$search}%");
            });
        }

        // 3. Filter Kategori (Mencari Target berdasarkan Kategori Indikatornya)
        if ($request->filled('kategori')) {
            $kategoriId = $request->kategori;
            $query->whereHas('indikator', function($q) use ($kategoriId) {
                $q->where('id_kategori', $kategoriId);
            });
        }

        // 4. Filter Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // 5. Pagination
        $targets = $query->orderBy('id_target', 'desc')
                         ->paginate(10)
                         ->withQueryString();

        // Data pendukung untuk dropdown filter di View
        $kategoris = KategoriKpi::orderBy('nama_kategori', 'asc')->get();

        return view('admin.target.index', compact('targets', 'kategoris'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $indikators = IndikatorKpi::where('status', 'Aktif')->get();
        return view('admin.target.create', compact('indikators'));
    }

    /**
     * Store a newly created resource in storage.
     */
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
        $target = TargetKpi::findOrFail($id);
        $indikators = IndikatorKpi::where('status', 'Aktif')->get();

        return view('admin.target.edit', compact('target', 'indikators'));
    }

    /**
     * Update the specified resource in storage.
     */
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $target = TargetKpi::findOrFail($id);
        $target->delete();

        return redirect()->route('target.index')->with('success', 'Target KPI berhasil dihapus!');
    }
}
