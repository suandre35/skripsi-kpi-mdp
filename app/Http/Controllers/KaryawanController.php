<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karyawan;
use App\Models\User;
use App\Models\Divisi;

class KaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // 1. Query dengan Eager Loading (User & Divisi)
        $query = Karyawan::with(['user', 'divisi']);

        // 2. Filter Search (NIK atau Nama)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_lengkap', 'LIKE', "%{$search}%")
                ->orWhere('nik', 'LIKE', "%{$search}%");
            });
        }

        // 3. Filter Divisi
        if ($request->filled('divisi')) {
            $query->where('id_divisi', $request->divisi);
        }

        // 4. Filter Status
        if ($request->filled('status')) {
            $query->where('status_karyawan', $request->status);
        }

        // 5. Pagination
        $karyawans = $query->orderBy('nama_lengkap', 'asc')
                        ->paginate(10)
                        ->withQueryString();

        // 6. Ambil data divisi untuk dropdown filter
        $divisis = Divisi::all();

        return view('admin.karyawan.index', compact('karyawans', 'divisis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::where('status', 'Aktif')->doesntHave('karyawan')->get();

        $divisis = Divisi::where('status', 'Aktif')->get();

        return view('admin.karyawan.create', compact('users', 'divisis'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_user'         => 'required|unique:karyawans,id_user', // Satu User Satu Karyawan
            'nik'             => 'required|unique:karyawans,nik',
            'nama_lengkap'    => 'required|string|max:150',
            'id_divisi'       => 'nullable|exists:divisis,id_divisi',
            'tanggal_masuk'   => 'required|date',
            'status_karyawan' => 'required|in:Aktif,Nonaktif',
        ]);

        Karyawan::create($request->all());

        return redirect()->route('karyawan.index')->with('success', 'Data Karyawan berhasil ditambahkan!');
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
        $karyawan = Karyawan::findOrFail($id);

        $users = User::where('status', 'Aktif')->doesntHave('karyawan')->orWhere('id_user', $karyawan->id_user)->get();

        $divisis = Divisi::where('status', 'Aktif')->get();

        return view('admin.karyawan.edit', compact('karyawan', 'users', 'divisis'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $karyawan = Karyawan::findOrFail($id);

        $request->validate([
            'id_user'         => 'required|unique:karyawans,id_user,'.$karyawan->id_karyawan.',id_karyawan',
            'nik'             => 'required|unique:karyawans,nik,'.$karyawan->id_karyawan.',id_karyawan',
            'nama_lengkap'    => 'required|string|max:150',
            'id_divisi'       => 'nullable|exists:divisis,id_divisi',
            'status_karyawan' => 'required|in:Aktif,Nonaktif',
        ]);

        $karyawan->update($request->except(['tanggal_masuk'])); 

        return redirect()->route('karyawan.index')->with('success', 'Data Karyawan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return redirect()->back()->with('error', 'Fitur hapus dinonaktifkan. Silakan ubah status menjadi Nonaktif.');
    }
}
