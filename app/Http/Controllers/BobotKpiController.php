<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Models\BobotKpi;
use App\Models\KategoriKpi;
use App\Models\IndikatorKpi;
use App\Models\PenilaianDetail;
use App\Models\Divisi;

class BobotKpiController extends Controller
{
    public function index(Request $request)
    {
        $query = BobotKpi::with(['indikator.kategori']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('indikator', function($q) use ($search) {
                $q->where('nama_indikator', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('divisi')) {
            $divisiId = $request->divisi;
            $query->whereHas('indikator', function($q) use ($divisiId) {
                $q->whereJsonContains('target_divisi', $divisiId);
            });
        }

        if ($request->filled('kategori')) {
            $kategoriId = $request->kategori;
            $query->whereHas('indikator', function($q) use ($kategoriId) {
                $q->where('id_kategori', $kategoriId);
            });
        }

        $bobots = $query->orderBy('nilai_bobot', 'desc')->paginate(10)->withQueryString();
        $kategoris = KategoriKpi::orderBy('nama_kategori', 'asc')->get();
        $divisis = Divisi::where('status', true)->orderBy('nama_divisi', 'asc')->get();

        return view('admin.bobot.index', compact('bobots', 'kategoris', 'divisis'));
    }

    public function create()
    {
        // 1. Ambil indikator yang belum punya bobot
        $indikators = IndikatorKpi::where('status', true)
                        ->whereDoesntHave('bobot') 
                        ->get();

        // 2. Hitung Penggunaan Bobot Per Divisi
        $divisiUsage = $this->getDivisiUsage();

        return view('admin.bobot.create', compact('indikators', 'divisiUsage'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_indikator' => 'required|exists:indikator_kpis,id_indikator|unique:bobot_kpis,id_indikator',
            'nilai_bobot'  => 'required|integer|min:1|max:100',
        ]);

        // Validasi Backend (Double Check)
        $errorMsg = $this->validateTotalBobot($request->id_indikator, $request->nilai_bobot);
        if ($errorMsg) {
            return redirect()->back()->withInput()->with('error', $errorMsg);
        }

        BobotKpi::create([
            'id_indikator' => $request->id_indikator,
            'nilai_bobot'  => $request->nilai_bobot,
        ]);

        return redirect()->route('bobot.index')->with('success', 'Bobot berhasil ditambahkan!');
    }

    public function edit(string $id)
    {
        $bobot = BobotKpi::findOrFail($id);
        
        // Indikator: Diri sendiri + yang belum punya bobot
        $indikators = IndikatorKpi::where('status', true)
                        ->where(function($q) use ($bobot) {
                            $q->whereDoesntHave('bobot')
                              ->orWhere('id_indikator', $bobot->id_indikator);
                        })->get();

        // Hitung Penggunaan Bobot (Kecuali bobot ini sendiri, agar saat edit tidak dobel hitung)
        $divisiUsage = $this->getDivisiUsage($bobot->id_bobot);

        return view('admin.bobot.edit', compact('bobot', 'indikators', 'divisiUsage'));
    }

    public function update(Request $request, string $id)
    {
        $bobot = BobotKpi::findOrFail($id);

        $request->validate([
            'id_indikator' => 'required|exists:indikator_kpis,id_indikator|unique:bobot_kpis,id_indikator,'.$id.',id_bobot',
            'nilai_bobot'  => 'required|integer|min:1|max:100',
        ]);

        // Validasi Backend
        $errorMsg = $this->validateTotalBobot($request->id_indikator, $request->nilai_bobot, $bobot->id_bobot);
        if ($errorMsg) {
            return redirect()->back()->withInput()->with('error', $errorMsg);
        }

        $bobot->update([
            'id_indikator' => $request->id_indikator,
            'nilai_bobot'  => $request->nilai_bobot,
        ]);

        return redirect()->route('bobot.index')->with('success', 'Bobot berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     * Bobot boleh dihapus, tapi berikan notifikasi.
     */
    public function destroy(string $id)
    {
        // 1. Cari Data Bobot
        $bobot = BobotKpi::findOrFail($id);

        // 2. VALIDASI MANUAL (Safety Check)
        // Cek ke tabel Penilaian/Realisasi: Apakah indikator dari bobot ini sudah pernah dinilai?
        // Sesuaikan 'PenilaianKpi' dengan nama model penilaian Anda sebenarnya.
        $sedangDigunakan = PenilaianDetail::where('id_indikator', $bobot->id_indikator)->exists();

        if ($sedangDigunakan) {
            // JIKA SUDAH DIPAKAI: Tolak keras tanpa saran "nonaktifkan".
            return redirect()->back()->with('error', 'Gagal Menghapus! Bobot ini tidak bisa dihapus karena Indikator terkait sudah memiliki riwayat penilaian karyawan. Menghapusnya akan merusak perhitungan laporan.');
        }

        // 3. EKSEKUSI HAPUS (Jika aman)
        try {
            $bobot->delete();
            
            return redirect()->route('bobot.index')
                ->with('success', 'Bobot berhasil dihapus permanen.');

        } catch (QueryException $e) {
            // Jaga-jaga error database level (constraint)
            return redirect()->back()->with('error', 'Terjadi kesalahan database saat menghapus data.');
        }
    }

    // --- HELPER FUNCTIONS ---

    private function getDivisiUsage($excludeBobotId = null)
    {
        $divisis = Divisi::where('status', true)->get();
        $usageData = [];

        foreach ($divisis as $divisi) {
            // Cari Indikator yang punya target ke divisi ini
            $totalUsed = BobotKpi::whereHas('indikator', function($q) use ($divisi) {
                $q->whereJsonContains('target_divisi', (string)$divisi->id_divisi);
            })
            ->when($excludeBobotId, function($q) use ($excludeBobotId) {
                $q->where('id_bobot', '!=', $excludeBobotId);
            })
            ->sum('nilai_bobot');

            $usageData[$divisi->id_divisi] = [
                'nama' => $divisi->nama_divisi,
                'used' => (int)$totalUsed,
                'sisa' => 100 - (int)$totalUsed
            ];
        }

        return $usageData;
    }

    private function validateTotalBobot($idIndikatorBaru, $nilaiBobotBaru, $excludeBobotId = null)
    {
        $indikatorBaru = IndikatorKpi::findOrFail($idIndikatorBaru);
        $targetDivisiArr = $indikatorBaru->target_divisi ?? []; 

        if (empty($targetDivisiArr)) return null;

        foreach ($targetDivisiArr as $divisiIdStr) {
            $totalBobotExisting = BobotKpi::whereHas('indikator', function($q) use ($divisiIdStr) {
                $q->whereJsonContains('target_divisi', $divisiIdStr);
            })
            ->when($excludeBobotId, function($q) use ($excludeBobotId) {
                $q->where('id_bobot', '!=', $excludeBobotId);
            })
            ->sum('nilai_bobot');

            $totalProyeksi = $totalBobotExisting + $nilaiBobotBaru;

            if ($totalProyeksi > 100) {
                $namaDivisi = Divisi::find($divisiIdStr)->nama_divisi ?? 'Divisi ID '.$divisiIdStr;
                return "Gagal! Total bobot untuk **$namaDivisi** akan menjadi {$totalProyeksi}%. Maksimal 100%. (Sisa kuota: " . (100 - $totalBobotExisting) . "%)";
            }
        }
        return null; 
    }
}