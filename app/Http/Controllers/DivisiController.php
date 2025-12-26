<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Divisi;
use App\Models\User;

class DivisiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $divisis = Divisi::with('manajer')->get();
        return view('admin.divisi.index', compact('divisis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $manajers = User::where('role', 'Manajer')->where('status', 'Aktif')->get();
                        
        return view('admin.divisi.create', compact('manajers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_divisi' => 'required|string|max:100|unique:divisis,nama_divisi',
            'id_manajer'  => 'required|exists:users,id_user',
            'status'      => 'required|in:Aktif,Nonaktif',
        ]);

        Divisi::create($request->all());

        return redirect()->route('divisi.index')->with('success', 'Divisi berhasil ditambahkan!');
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
        $divisi = Divisi::findOrFail($id);
        
        $manajers = User::where('role', 'Manajer')->where('status', 'Aktif')->get();

        return view('admin.divisi.edit', compact('divisi', 'manajers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $divisi = Divisi::findOrFail($id);

        $request->validate([
            'nama_divisi' => 'required|string|max:100|unique:divisis,nama_divisi,'.$divisi->id_divisi.',id_divisi',
            'id_manajer'  => 'required|exists:users,id_user',
            'status'      => 'required|in:Aktif,Nonaktif',
        ]);

        $divisi->update($request->all());

        return redirect()->route('divisi.index')->with('success', 'Divisi berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return redirect()->back()->with('error', 'Fitur hapus dinonaktifkan. Silakan ubah status menjadi Nonaktif.');
    }
}
