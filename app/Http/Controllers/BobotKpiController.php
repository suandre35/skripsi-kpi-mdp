<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BobotKpi;
use App\Models\IndikatorKpi;

class BobotKpiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bobots = BobotKpi::with('indikator')->get();
        return view('admin.bobot.index', compact('bobots'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $indikators = IndikatorKpi::where('status', 'Aktif')->get();
        return view('admin.bobot.create', compact('indikators'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_indikator' => 'required|exists:indikator_kpis,id_indikator',
            'nilai_bobot'  => 'required|integer|min:1|max:100',
        ]);

        BobotKpi::create([
            'id_indikator' => $request->id_indikator,
            'nilai_bobot'  => $request->nilai_bobot,
            'status'       => 'Aktif',
        ]);

        return redirect()->route('bobot.index')->with('success', 'Bobot berhasil ditambahkan!');
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
        $bobot = BobotKpi::findOrFail($id);
        $indikators = IndikatorKpi::where('status', 'Aktif')->get();
        return view('admin.bobot.edit', compact('bobot', 'indikators'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'id_indikator' => 'required|exists:indikator_kpis,id_indikator',
            'nilai_bobot'  => 'required|integer|min:1|max:100',
            'status'       => ['required', 'in:Aktif,Nonaktif'],
        ]);

        $bobot = BobotKpi::findOrFail($id);
        $bobot->update([
            'id_indikator' => $request->id_indikator,
            'nilai_bobot'  => $request->nilai_bobot,
            'status'       => $request->status,
        ]);

        return redirect()->route('bobot.index')->with('success', 'Bobot berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $bobot = BobotKpi::findOrFail($id);
        $bobot->delete();
        
        return redirect()->route('bobot.index')->with('success', 'Bobot berhasil dihapus!');
    }
}
