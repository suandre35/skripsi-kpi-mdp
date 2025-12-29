<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PeriodeEvaluasi;

class PeriodeEvaluasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $periodes = PeriodeEvaluasi::orderBy('created_at', 'desc')->paginate(10);

        $periodeAktif = PeriodeEvaluasi::where('status', 'Aktif')->first();

        return view('admin.periode.index', compact('periodes', 'periodeAktif'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.periode.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_periode'       => 'required|string|max:100',
            'tanggal_mulai'      => 'required|date',
            'tanggal_selesai'    => 'required|date|after:tanggal_mulai',
            'tanggal_pengumuman' => 'required|date|after:tanggal_selesai',
            'status'             => 'required|in:Aktif,Nonaktif',
        ]);

        if ($request->status == 'Aktif') {
            PeriodeEvaluasi::where('status', 'Aktif')->update(['status' => 'Nonaktif']);
        }

        PeriodeEvaluasi::create($validated);

        return redirect()->route('periode.index')->with('success', 'Periode Evaluasi berhasil ditambahkan!');
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
        $periode = PeriodeEvaluasi::findOrFail($id);
        return view('admin.periode.edit', compact('periode'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'nama_periode'       => 'required|string|max:100',
            'tanggal_mulai'      => 'required|date',
            'tanggal_selesai'    => 'required|date|after:tanggal_mulai',
            'tanggal_pengumuman' => 'required|date|after:tanggal_selesai',
            'status'             => 'required|in:Aktif,Nonaktif',
        ]);

        if ($request->status == 'Aktif') {
            PeriodeEvaluasi::where('id_periode', '!=', $id)->update(['status' => 'Nonaktif']);
        }

        $periode = PeriodeEvaluasi::findOrFail($id);
        
        $periode->update($validated);

        return redirect()->route('periode.index')->with('success', 'Periode Evaluasi berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $periode = PeriodeEvaluasi::findOrFail($id);
        $periode->delete();

        return redirect()->route('periode.index')->with('success', 'Periode Evaluasi berhasil dihapus!');
    }
}
