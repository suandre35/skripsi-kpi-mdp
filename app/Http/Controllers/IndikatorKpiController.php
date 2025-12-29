<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IndikatorKpi;
use App\Models\KategoriKpi;
use App\Models\Divisi;

class IndikatorKpiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // 1. Query Dasar dengan Eager Loading
        $query = IndikatorKpi::with('kategori');

        // 2. Filter Search (Nama Indikator)
        if ($request->filled('search')) {
            $query->where('nama_indikator', 'LIKE', "%{$request->search}%");
        }

        // 3. Filter Kategori (Dropdown)
        if ($request->filled('kategori')) {
            $query->where('id_kategori', $request->kategori);
        }

        // 4. Filter Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // 5. Pagination
        $indikators = $query->orderBy('nama_indikator', 'asc')
                            ->paginate(10)
                            ->withQueryString();

        // 6. Data Pendukung untuk View
        // Mapping ID Divisi ke Nama: [1 => 'IT', 2 => 'HRD'] agar query ringan di view
        $allDivisi = Divisi::pluck('nama_divisi', 'id_divisi')->toArray();
        
        // List Kategori untuk Dropdown Filter
        $kategoris = KategoriKpi::where('status', 'Aktif')->get();

        return view('admin.indikator.index', compact('indikators', 'allDivisi', 'kategoris'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategoris = KategoriKpi::where('status', 'Aktif')->get();
        $divisis = Divisi::where('status', 'Aktif')->get();
        
        return view('admin.indikator.create', compact('kategoris', 'divisis'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_kategori'   => 'required|exists:kategori_kpis,id_kategori',
            'target_divisi'     => 'required|array',
            'target_divisi.*'   => 'exists:divisis,id_divisi',
            'nama_indikator'        => 'required|string|max:150',
            'satuan_pengukuran'     => 'nullable|string|max:50', // Contoh: %, Poin, Kali
            'deskripsi'     => 'nullable|string',
        ]);

        // IndikatorKpi::create($request->all());
        $data = $request->all();
        $data['status'] = 'Aktif';

        IndikatorKpi::create($data);

        return redirect()->route('indikator.index')->with('success', 'Indikator berhasil ditambahkan!');
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
        $indikator = IndikatorKpi::findOrFail($id);
        $kategoris = KategoriKpi::where('status', 'Aktif')->get();
        $divisis = Divisi::where('status', 'Aktif')->get();

        return view('admin.indikator.edit', compact('indikator', 'kategoris','divisis'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'id_kategori'       => 'required|exists:kategori_kpis,id_kategori',
            'target_divisi'     => 'required|array', 
            'target_divisi.*'   => 'exists:divisis,id_divisi',
            'nama_indikator'    => 'required|string|max:150',
            'satuan_pengukuran' => 'nullable|string|max:50',
            'deskripsi'         => 'nullable|string',
            'status'            => ['required', 'in:Aktif,Nonaktif'], // Pakai array biar aman
        ]);

        $indikator = IndikatorKpi::findOrFail($id);
        $indikator->update($request->all());

        return redirect()->route('indikator.index')->with('success', 'Indikator berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return redirect()->back()->with('error', 'Indikator tidak boleh dihapus demi riwayat penilaian. Gunakan status Nonaktif.');
    }
}
