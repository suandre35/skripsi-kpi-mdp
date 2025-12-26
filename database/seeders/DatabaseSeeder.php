<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Divisi;
use App\Models\Karyawan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // =========================================================
        // 1. BUAT DAFTAR DIVISI
        // =========================================================
        
        // Divisi Direksi
        $divDireksi = Divisi::create([
            'nama_divisi' => 'Direksi',
            'status' => 'Aktif',
            // 'deskripsi' dihapus karena tidak ada di tabel
        ]);

        // Daftar Divisi Operasional
        $namaDivisi = ['HRD', 'Logistik', 'Keuangan', 'Accounting', 'Service', 'Store'];
        $listDivisi = [];

        foreach ($namaDivisi as $nama) {
            $listDivisi[$nama] = Divisi::create([
                'nama_divisi' => $nama,
                'status' => 'Aktif',
            ]);
        }

        // =========================================================
        // 2. CONTOH USER: DIREKTUR (Puncak Struktur)
        // =========================================================
        $userDirektur = User::create([
            'name' => 'Bapak Direktur',
            'email' => 'direktur@kantor.com',
            'password' => Hash::make('password'),
            'role' => 'Manajer', // Role Manajer untuk level pimpinan
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
        
        // UPDATE MANAJER DIVISI (Pakai id_manajer ke User, BUKAN Karyawan)
        $divDireksi->update(['id_manajer' => $userDirektur->id_user]);


        /// =========================================================
        // 3. CONTOH USER: MANAGER HRD (Sebagai Admin Sistem)
        // =========================================================
        $userHRD = User::create([
            'name' => 'Manajer HRD',
            'email' => 'hrd@kantor.com',
            'password' => Hash::make('password'),
            'role' => 'HRD',
            'status' => 'Aktif',
        ]);

        Karyawan::create([
            'id_user' => $userHRD->id_user,
            'id_divisi' => $listDivisi['HRD']->id_divisi,
            'nik' => '1001',
            'nama_lengkap' => 'Siti Aminah (Manajer HRD)',
            'tanggal_masuk' => '2015-05-20',
            'status_karyawan' => 'Aktif',
        ]);

        // Update Divisi HRD (Manajer = User HRD)
        $listDivisi['HRD']->update(['id_manajer' => $userHRD->id_user]);


        // =========================================================
        // 4. CONTOH USER: MANAJER STORE (Untuk Tes Penilaian)
        // =========================================================
        $userManajerStore = User::create([
            'name' => 'Manajer Store',
            'email' => 'manajer.store@kantor.com',
            'password' => Hash::make('password'),
            'role' => 'Manajer',
            'status' => 'Aktif',
        ]);

        Karyawan::create([
            'id_user' => $userManajerStore->id_user,
            'id_divisi' => $listDivisi['Store']->id_divisi,
            'nik' => '6001',
            'nama_lengkap' => 'Andi Pratama (Manajer Store)',
            'tanggal_masuk' => '2018-03-10',
            'status_karyawan' => 'Aktif',
        ]);

        // Update Divisi Store (Manajer = User Manajer Store)
        $listDivisi['Store']->update(['id_manajer' => $userManajerStore->id_user]);


        // =========================================================
        // 5. CONTOH USER: STAFF STORE (Bawahan Manajer Store)
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
            'id_divisi' => $listDivisi['Store']->id_divisi,
            'nik' => '6005',
            'nama_lengkap' => 'Rina Wati (Staff Store)',
            'tanggal_masuk' => '2022-08-17',
            'status_karyawan' => 'Aktif',
        ]);
    }
}
