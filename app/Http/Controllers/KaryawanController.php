<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karyawan;
use App\Models\User;
use App\Models\Divisi;
use Illuminate\Support\Facades\Storage;

class KaryawanController extends Controller
{
    public function index(Request $request)
    {
        // Query dengan Eager Loading
        $query = Karyawan::with(['user', 'divisi']);

        // Filter Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_lengkap', 'LIKE', "%{$search}%")
                ->orWhere('nik', 'LIKE', "%{$search}%");
            });
        }

        // Filter Divisi
        if ($request->filled('divisi')) {
            $query->where('id_divisi', $request->divisi);
        }

        // Filter Status
        if ($request->filled('status')) {
            $query->where('status_karyawan', $request->status);
        }

        // Pagination
        $karyawans = $query->orderBy('nama_lengkap', 'asc')->paginate(10)->withQueryString();
        $divisis = Divisi::all();

        return view('admin.karyawan.index', compact('karyawans', 'divisis'));
    }

    public function create()
    {
        $users = User::where('status', 'Aktif')->doesntHave('karyawan')->get();
        $divisis = Divisi::where('status', 'Aktif')->get();

        return view('admin.karyawan.create', compact('users', 'divisis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_user'         => 'required|unique:karyawans,id_user',
            'nik'             => 'required|unique:karyawans,nik',
            'nama_lengkap'    => 'required|string|max:150',
            'jenis_kelamin'   => 'required|in:L,P', // Validasi Baru
            'tanggal_lahir'   => 'required|date',   // Validasi Baru
            'alamat'          => 'nullable|string', // Validasi Baru
            'foto'            => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Validasi Foto (Max 2MB)
            'id_divisi'       => 'nullable|exists:divisis,id_divisi',
            'tanggal_masuk'   => 'required|date',
            'status_karyawan' => 'required|in:Aktif,Nonaktif',
        ]);

        $data = $request->all();

        // Handle Upload Foto
        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('foto-karyawan', 'public');
            $data['foto'] = $path;
        }

        Karyawan::create($data);

        return redirect()->route('karyawan.index')->with('success', 'Data Karyawan berhasil ditambahkan!');
    }

    public function edit(string $id)
    {
        $karyawan = Karyawan::findOrFail($id);
        // User yang bisa dipilih: user saat ini ATAU user yang belum punya karyawan
        $users = User::where('status', 'Aktif')
                     ->doesntHave('karyawan')
                     ->orWhere('id_user', $karyawan->id_user)
                     ->get();
        $divisis = Divisi::where('status', 'Aktif')->get();

        return view('admin.karyawan.edit', compact('karyawan', 'users', 'divisis'));
    }

    public function update(Request $request, $id)
    {
        $karyawan = Karyawan::findOrFail($id);

        $request->validate([
            'id_user'         => 'required|unique:karyawans,id_user,'.$karyawan->id_karyawan.',id_karyawan',
            'nik'             => 'required|unique:karyawans,nik,'.$karyawan->id_karyawan.',id_karyawan',
            'nama_lengkap'    => 'required|string|max:150',
            'jenis_kelamin'   => 'required|in:L,P',
            'tanggal_lahir'   => 'required|date',
            'alamat'          => 'nullable|string',
            'foto'            => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'id_divisi'       => 'nullable|exists:divisis,id_divisi',
            'status_karyawan' => 'required|in:Aktif,Nonaktif',
        ]);

        $data = $request->except(['foto']); // Foto diproses manual

        // Handle Update Foto
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($karyawan->foto && Storage::disk('public')->exists($karyawan->foto)) {
                Storage::disk('public')->delete($karyawan->foto);
            }
            $path = $request->file('foto')->store('foto-karyawan', 'public');
            $data['foto'] = $path;
        }

        $karyawan->update($data);

        return redirect()->route('karyawan.index')->with('success', 'Data Karyawan berhasil diperbarui!');
    }

    public function destroy(string $id)
    { 
        return redirect()->back()->with('error', 'Fitur hapus dinonaktifkan. Silakan ubah status menjadi Nonaktif.');
    }
}