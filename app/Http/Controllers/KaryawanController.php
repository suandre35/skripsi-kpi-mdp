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
        $query = Karyawan::with(['user', 'divisi']);

        // 1. Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_lengkap', 'LIKE', "%{$search}%")
                ->orWhere('nik', 'LIKE', "%{$search}%");
            });
        }

        // 2. Filter Divisi
        if ($request->filled('divisi')) {
            $query->where('id_divisi', $request->divisi);
        }

        // 3. Filter Status (Boolean)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $karyawans = $query->orderBy('nama_lengkap', 'asc')->paginate(10)->withQueryString();
        $divisis = Divisi::where('status', true)->orderBy('nama_divisi', 'asc')->get();

        return view('admin.karyawan.index', compact('karyawans', 'divisis'));
    }

    public function create()
    {
        $users = User::where('status', true)->doesntHave('karyawan')->get();
        $divisis = Divisi::where('status', true)->orderBy('nama_divisi', 'asc')->get();

        return view('admin.karyawan.create', compact('users', 'divisis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_user'       => 'required|unique:karyawans,id_user',
            'id_divisi'     => 'required|exists:divisis,id_divisi',
            'nik'           => 'required|unique:karyawans,nik',
            'nama_lengkap'  => 'required|string|max:150',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir'  => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'alamat'        => 'required|string',
            'foto'          => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'no_telepon'    => 'required|string|max:20',
            'email'=> 'required|email|unique:karyawans,email',
            'tanggal_masuk' => 'required|date',
            'status'        => 'required|boolean', // Validasi Boolean
        ]);

        $data = $request->all();

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
        
        $users = User::where('status', true)
                     ->doesntHave('karyawan')
                     ->orWhere('id_user', $karyawan->id_user)
                     ->get();
                     
        $divisis = Divisi::where('status', true)->orderBy('nama_divisi', 'asc')->get();

        return view('admin.karyawan.edit', compact('karyawan', 'users', 'divisis'));
    }

    public function update(Request $request, $id)
    {
        $karyawan = Karyawan::findOrFail($id);

        $request->validate([
            'id_user'       => 'required|unique:karyawans,id_user,'.$karyawan->id_karyawan.',id_karyawan',
            'nik'           => 'required|unique:karyawans,nik,'.$karyawan->id_karyawan.',id_karyawan',
            'id_divisi'     => 'nullable|exists:divisis,id_divisi',
            'nama_lengkap'  => 'required|string|max:150',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir'  => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'alamat'        => 'nullable|string',
            'foto'          => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'no_telepon'    => 'required|string|max:20',
            'email'=> 'required|email|unique:karyawans,email',
            'status'        => 'required|boolean', // Validasi Boolean
        ]);

        $data = $request->except(['foto']);

        if ($request->hasFile('foto')) {
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