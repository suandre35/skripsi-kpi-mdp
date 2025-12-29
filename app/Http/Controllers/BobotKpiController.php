<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BobotKpi;
use App\Models\KategoriKpi;
use App\Models\IndikatorKpi;
use App\Models\Divisi; // 1. IMPORT DIVISI

class BobotKpiController extends Controller
{
    public function index(Request $request)
    {
        // 1. Query Dasar dengan Eager Loading
        $query = BobotKpi::with(['indikator.kategori']);

        // 2. Filter Search (Nama Indikator)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('indikator', function($q) use ($search) {
                $q->where('nama_indikator', 'LIKE', "%{$search}%");
            });
        }

        // 3. Filter Divisi (BARU - Mencari ID Divisi di dalam JSON target_divisi milik Indikator)
        if ($request->filled('divisi')) {
            $divisiId = $request->divisi;
            $query->whereHas('indikator', function($q) use ($divisiId) {
                // Mencari apakah ID Divisi ada di dalam array JSON target_divisi
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
        $bobots = $query->orderBy('nilai_bobot', 'desc')
                        ->paginate(10)
                        ->withQueryString();

        // Data Pendukung untuk Dropdown Filter
        $kategoris = KategoriKpi::orderBy('nama_kategori', 'asc')->get();
        $divisis = Divisi::where('status', 'Aktif')->orderBy('nama_divisi', 'asc')->get(); // Ambil data divisi

        return view('admin.bobot.index', compact('bobots', 'kategoris', 'divisis'));
    }

    // ... method create, store, edit, update, destroy TETAP SAMA ...
    
    public function create()
    {
        $indikators = IndikatorKpi::where('status', 'Aktif')->get();
        return view('admin.bobot.create', compact('indikators'));
    }

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

    public function edit(string $id)
    {
        $bobot = BobotKpi::findOrFail($id);
        $indikators = IndikatorKpi::where('status', 'Aktif')->get();
        return view('admin.bobot.edit', compact('bobot', 'indikators'));
    }

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

    public function destroy(string $id)
    {
        $bobot = BobotKpi::findOrFail($id);
        $bobot->delete();
        
        return redirect()->route('bobot.index')->with('success', 'Bobot berhasil dihapus!');
    }
}