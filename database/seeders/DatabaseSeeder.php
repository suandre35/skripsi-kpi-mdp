<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Divisi;
use App\Models\Karyawan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // =========================================================
        // 1. BUAT DAFTAR DIVISI SESUAI GAMBAR STRUKTUR ORGANISASI
        // =========================================================
        
        // Divisi khusus untuk Pimpinan Tertinggi
        $divDireksi = Divisi::create([
            'nama_divisi' => 'Direksi',
            'deskripsi' => 'Pimpinan tertinggi perusahaan (Direktur & Wakil).',
        ]);

        // Daftar Divisi Operasional (Sesuai kotak ungu di gambar)
        $namaDivisi = ['HRD', 'Logistik', 'Keuangan', 'Accounting', 'Service', 'Store'];
        $listDivisi = [];

        foreach ($namaDivisi as $nama) {
            $listDivisi[$nama] = Divisi::create([
                'nama_divisi' => $nama,
                'deskripsi' => "Divisi operasional bagian $nama.",
            ]);
        }

        // =========================================================
        // 2. CONTOH USER: DIREKTUR (Puncak Struktur)
        // =========================================================
        $userDirektur = User::create([
            'name' => 'Bapak Direktur',
            'email' => 'direktur@kantor.com',
            'password' => Hash::make('password'),
            'role' => 'Manajer', // Di sistem dianggap Manajer Tertinggi
            'status' => 'Aktif',
        ]);

        Karyawan::create([
            'id_user' => $userDirektur->id_user,
            'id_divisi' => $divDireksi->id_divisi,
            'nik' => '001',
            'nama_lengkap' => 'Budi Santoso (Direktur Utama)',
            'tanggal_masuk' => '2010-01-01',
            'status_karyawan' => 'Aktif',
        ]);
        
        // Set dia sebagai kepala Divisi Direksi
        $divDireksi->update(['id_kepala_divisi' => 1]); // ID 1 karena dia created pertama


        // =========================================================
        // 3. CONTOH USER: MANAGER HRD (Admin Sistem)
        // =========================================================
        $userHRD = User::create([
            'name' => 'Manager HRD',
            'email' => 'hrd@kantor.com',
            'password' => Hash::make('password'),
            'role' => 'HRD', // Role khusus HRD
            'status' => 'Aktif',
        ]);

        $karyawanHRD = Karyawan::create([
            'id_user' => $userHRD->id_user,
            'id_divisi' => $listDivisi['HRD']->id_divisi,
            'nik' => '1001',
            'nama_lengkap' => 'Siti Aminah (Manager HRD)',
            'tanggal_masuk' => '2015-05-20',
            'status_karyawan' => 'Aktif',
        ]);

        // Update Divisi HRD punya kepala
        $listDivisi['HRD']->update(['id_kepala_divisi' => $karyawanHRD->id_karyawan]);


        // =========================================================
        // 4. CONTOH USER: MANAGER STORE (Untuk Tes Penilaian)
        // =========================================================
        $userManagerStore = User::create([
            'name' => 'Manager Store',
            'email' => 'manager.store@kantor.com',
            'password' => Hash::make('password'),
            'role' => 'Manajer',
            'status' => 'Aktif',
        ]);

        $karyawanManagerStore = Karyawan::create([
            'id_user' => $userManagerStore->id_user,
            'id_divisi' => $listDivisi['Store']->id_divisi, // Masuk Divisi Store
            'nik' => '6001',
            'nama_lengkap' => 'Andi Pratama (Manager Store)',
            'tanggal_masuk' => '2018-03-10',
            'status_karyawan' => 'Aktif',
        ]);

        // Update Divisi Store -> Kepalanya adalah Andi
        $listDivisi['Store']->update(['id_kepala_divisi' => $karyawanManagerStore->id_karyawan]);


        // =========================================================
        // 5. CONTOH USER: STAFF STORE (Bawahan Manager Store)
        // =========================================================
        $userStaffStore = User::create([
            'name' => 'Staff Store',
            'email' => 'staff.store@kantor.com',
            'password' => Hash::make('password'),
            'role' => 'Karyawan',
            'status' => 'Aktif',
        ]);

        Karyawan::create([
            'id_user' => $userStaffStore->id_user,
            'id_divisi' => $listDivisi['Store']->id_divisi, // Satu divisi sama Manager Store
            'nik' => '6005',
            'nama_lengkap' => 'Rina Wati (Staff Store)',
            'tanggal_masuk' => '2022-08-17',
            'status_karyawan' => 'Aktif',
        ]);
    }
}
