<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriKpi;

class KategoriKpiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // 1. Query Dasar
        $query = KategoriKpi::query();

        // 2. Filter Search (Nama Kategori)
        if ($request->filled('search')) {
            $query->where('nama_kategori', 'LIKE', "%{$request->search}%");
        }

        // 3. Filter Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // 4. Pagination
        $kategoris = $query->orderBy('nama_kategori', 'asc')
                        ->paginate(10)
                        ->withQueryString();

        return view('admin.kategori.index', compact('kategoris'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.kategori.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:100',
            'deskripsi'     => 'nullable|string',
            'status'        => 'required|boolean',
        ]);

        KategoriKpi::create($request->all());

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan!');
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
        $kategori = KategoriKpi::findOrFail($id);

        return view('admin.kategori.edit', compact('kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $kategori = KategoriKpi::findOrFail($id);

        $request->validate([
            'nama_kategori' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'status'        => 'required|boolean',
        ]);

        $kategori->update($request->all());

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kategori = KategoriKpi::findOrFail($id);

        // Cek apakah kategori masih dipakai di indikator
        if ($kategori->indikators()->exists()) {
            return back()->with('error', 'Gagal menghapus! Kategori ini sedang digunakan oleh Indikator KPI. Silakan nonaktifkan statusnya saja jika tidak ingin digunakan.');
        }

        $kategori->delete();

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus permanen karena belum pernah digunakan.');
    }
}
