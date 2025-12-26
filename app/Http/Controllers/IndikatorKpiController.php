<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IndikatorKpi;
use App\Models\KategoriKpi;

class IndikatorKpiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $indikators = IndikatorKpi::with('kategori')->get();

        return view('admin.indikator.index', compact('indikators'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategoris = KategoriKpi::where('status', 'Aktif')->get();
        
        return view('admin.indikator.create', compact('kategoris'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_kategori'   => 'required|exists:kategori_kpis,id_kategori',
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

        return view('admin.indikator.edit', compact('indikator', 'kategoris'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'id_kategori'       => 'required|exists:kategori_kpis,id_kategori',
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
        $indikator = IndikatorKpi::findOrFail($id);
        $indikator->delete();

        return redirect()->route('indikator.index')->with('success', 'Indikator berhasil dihapus!');
    }
}
