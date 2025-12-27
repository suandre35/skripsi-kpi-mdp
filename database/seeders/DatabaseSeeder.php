<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Divisi;
use App\Models\Karyawan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. BERSIHKAN DATABASE (Agar tidak duplikat saat dijalankan ulang)
        Schema::disableForeignKeyConstraints();
        Karyawan::truncate();
        Divisi::truncate();
        User::truncate();
        Schema::enableForeignKeyConstraints();

        $passwordDefault = Hash::make('password'); // Password untuk semua akun

        // =====================================================================
        // BAGIAN 1: LEVEL DIREKSI (PIMPINAN)
        // =====================================================================
        
        // Buat Divisi Khusus Direksi
        $divDireksi = Divisi::create([
            'nama_divisi' => 'Direksi',
            'deskripsi'   => 'Pimpinan Tertinggi Perusahaan',
            'status'      => 'Aktif',
        ]);

        // 1.1 Direktur Utama
        $userDirektur = User::create([
            'name'     => 'Bapak Direktur',
            'email'    => 'direktur@kantor.com',
            'password' => $passwordDefault,
            'role'     => 'Manajer', // Level tertinggi dianggap Manajer di sistem
            'status'   => 'Aktif',
        ]);

        Karyawan::create([
            'id_user'         => $userDirektur->id_user,
            'id_divisi'       => $divDireksi->id_divisi,
            'nik'             => 'DIR-001',
            'nama_lengkap'    => 'Budi Santoso (Direktur)',
            'tanggal_masuk'   => '2010-01-01',
            'status_karyawan' => 'Aktif',
        ]);

        // Set Kepala Divisi Direksi
        $divDireksi->update(['id_manajer' => $userDirektur->id_user]);

        // 1.2 Wakil Direktur
        $userWakil = User::create([
            'name'     => 'Ibu Wakil Direktur',
            'email'    => 'wakil@kantor.com',
            'password' => $passwordDefault,
            'role'     => 'Manajer',
            'status'   => 'Aktif',
        ]);

        Karyawan::create([
            'id_user'         => $userWakil->id_user,
            'id_divisi'       => $divDireksi->id_divisi,
            'nik'             => 'DIR-002',
            'nama_lengkap'    => 'Sari Rahmawati (Wakil Direktur)',
            'tanggal_masuk'   => '2012-05-15',
            'status_karyawan' => 'Aktif',
        ]);


        // =====================================================================
        // BAGIAN 2: MANAGER HRD (ADMIN SISTEM)
        // =====================================================================
        
        // Buat Divisi HRD
        $divHRD = Divisi::create([
            'nama_divisi' => 'HRD',
            'deskripsi'   => 'Human Resource Development',
            'status'      => 'Aktif',
        ]);

        // User Manager HRD (Role Khusus: HRD)
        $userManagerHRD = User::create([
            'name'     => 'Manager HRD',
            'email'    => 'hrd@kantor.com',
            'password' => $passwordDefault,
            'role'     => 'HRD', // <--- ROLE KHUSUS ADMIN
            'status'   => 'Aktif',
        ]);

        Karyawan::create([
            'id_user'         => $userManagerHRD->id_user,
            'id_divisi'       => $divHRD->id_divisi,
            'nik'             => 'HRD-001',
            'nama_lengkap'    => 'Siti Aminah (Manager HRD)',
            'tanggal_masuk'   => '2015-02-10',
            'status_karyawan' => 'Aktif',
        ]);

        // Update Kepala Divisi HRD
        $divHRD->update(['id_manajer' => $userManagerHRD->id_user]);

        // Staff HRD
        $userStaffHRD = User::create([
            'name'     => 'Staff HRD',
            'email'    => 'staff.hrd@kantor.com',
            'password' => $passwordDefault,
            'role'     => 'Karyawan',
            'status'   => 'Aktif',
        ]);

        Karyawan::create([
            'id_user'         => $userStaffHRD->id_user,
            'id_divisi'       => $divHRD->id_divisi,
            'nik'             => 'HRD-005',
            'nama_lengkap'    => 'Dewi Sartika (Staff HRD)',
            'tanggal_masuk'   => '2020-08-17',
            'status_karyawan' => 'Aktif',
        ]);


        // =====================================================================
        // BAGIAN 3: DIVISI & MANAGER LAINNYA (SESUAI STRUKTUR)
        // =====================================================================

        // Daftar Divisi selain HRD & Direksi
        $daftarDivisi = [
            'Logistik'   => ['mgr_name' => 'Manager Logistik',   'staff_name' => 'Staff Logistik'],
            'Keuangan'   => ['mgr_name' => 'Manager Keuangan',   'staff_name' => 'Staff Keuangan'],
            'Accounting' => ['mgr_name' => 'Manager Accounting', 'staff_name' => 'Staff Accounting'],
            'Service'    => ['mgr_name' => 'Manager Service',    'staff_name' => 'Staff Service'],
            'Store'      => ['mgr_name' => 'Manager Store',      'staff_name' => 'Staff Store'],
        ];

        $counter = 1; // Untuk generate NIK dummy

        foreach ($daftarDivisi as $namaDivisi => $personil) {
            
            // 3.1 Buat Divisi
            $divisi = Divisi::create([
                'nama_divisi' => $namaDivisi,
                'deskripsi'   => "Divisi operasional bagian $namaDivisi",
                'status'      => 'Aktif',
            ]);

            // 3.2 Buat User MANAGER
            $emailMgr = strtolower($namaDivisi) . '.mgr@kantor.com';
            $userManager = User::create([
                'name'     => $personil['mgr_name'],
                'email'    => $emailMgr,
                'password' => $passwordDefault,
                'role'     => 'Manajer', // Role Manajer
                'status'   => 'Aktif',
            ]);

            // Buat Data Karyawan Manager
            Karyawan::create([
                'id_user'         => $userManager->id_user,
                'id_divisi'       => $divisi->id_divisi,
                'nik'             => strtoupper(substr($namaDivisi, 0, 3)) . '-001',
                'nama_lengkap'    => 'Bpk/Ibu ' . $personil['mgr_name'],
                'tanggal_masuk'   => '2016-01-0' . $counter,
                'status_karyawan' => 'Aktif',
            ]);

            // Set User ini sebagai Kepala Divisi
            $divisi->update(['id_manajer' => $userManager->id_user]);


            // 3.3 Buat User STAFF (Karyawan)
            $emailStaff = strtolower($namaDivisi) . '.staff@kantor.com';
            $userStaff = User::create([
                'name'     => $personil['staff_name'],
                'email'    => $emailStaff,
                'password' => $passwordDefault,
                'role'     => 'Karyawan', // Role Karyawan Biasa
                'status'   => 'Aktif',
            ]);

            // Buat Data Karyawan Staff
            Karyawan::create([
                'id_user'         => $userStaff->id_user,
                'id_divisi'       => $divisi->id_divisi,
                'nik'             => strtoupper(substr($namaDivisi, 0, 3)) . '-005',
                'nama_lengkap'    => 'Sdr/i ' . $personil['staff_name'],
                'tanggal_masuk'   => '2021-06-1' . $counter,
                'status_karyawan' => 'Aktif',
            ]);

            $counter++;
        }
    }
}
