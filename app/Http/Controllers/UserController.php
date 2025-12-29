<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Mulai Query
        $query = User::query();

        // --- TAMBAHAN PENTING: Sembunyikan akun dengan role HRD ---
        $query->where('role', '!=', 'HRD');
        // ---------------------------------------------------------

        // 1. Logika Search (Cari Nama atau Email)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        // 2. Logika Filter Role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // 3. Logika Filter Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // 4. Pagination
        $users = $query->orderBy('name', 'asc')->paginate(10)->withQueryString();

        return view('admin.user.index', compact('users'));
    }

    // ... (Method create, store, edit, update, destroy TETAP SAMA, tidak perlu diubah) ...
    
    public function create()
    {
        return view('admin.user.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role'     => ['required', 'in:HRD,Manajer,Karyawan'],
            'status'   => ['required', 'in:Aktif,Nonaktif'],
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
            'status'   => $request->status,
        ]);

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan!');
    }

    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        
        // Opsional: Cegah edit akun HRD via URL hacking
        if ($user->role === 'HRD') {
             return redirect()->route('users.index')->with('error', 'Akun HRD tidak dapat diedit dari sini.');
        }

        return view('admin.user.edit', compact('user'));
    }

    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        // Opsional: Cegah update akun HRD
        if ($user->role === 'HRD') {
             return redirect()->route('users.index')->with('error', 'Akun HRD tidak dapat diubah.');
        }

        $request->validate([
            'name'   => ['required', 'string', 'max:255'],
            'email'  => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id_user.',id_user'],
            'role'   => ['required', 'in:HRD,Manajer,Karyawan'],
            'status' => ['required', 'in:Aktif,Nonaktif'],
        ]);

        $user->name   = $request->name;
        $user->email  = $request->email;
        $user->role   = $request->role;
        $user->status = $request->status;

        if ($request->filled('password')) {
            $request->validate([
                'password' => ['confirmed', Rules\Password::defaults()],
            ]);
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        
        // Opsional: Cegah hapus akun HRD
        if ($user->role === 'HRD') {
             return redirect()->route('users.index')->with('error', 'Akun HRD tidak dapat dihapus.');
        }
        
        if (auth()->user()->id_user == $id) {
            return back()->with('error', 'Anda tidak bisa menghapus akun sendiri!');
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'User berhasil dihapus!');
    }
}