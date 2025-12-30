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
    public function run(): void
    {
        // 1. BERSIHKAN DATABASE
        Schema::disableForeignKeyConstraints();
        Karyawan::truncate();
        Divisi::truncate();
        User::truncate();
        Schema::enableForeignKeyConstraints();

        $passwordDefault = Hash::make('password'); // Password: password

        // =====================================================================
        // BAGIAN 1: HRD (ADMIN / SUPERUSER)
        // =====================================================================
        
        // 1.1 Buat Divisi HRD
        $divHRD = Divisi::create([
            'nama_divisi' => 'Human Resource',
            // deskripsi (nullable) -> SKIP
            'status'      => true,
        ]);

        // 1.2 Buat User HRD
        $userHRD = User::create([
            'name'     => 'Manager HRD',
            'email'    => 'hrd@kantor.com',
            'password' => $passwordDefault,
            'role'     => 'HRD',
            'status'   => true,
        ]);

        // 1.3 Buat Data Karyawan HRD
        Karyawan::create([
            'id_user'       => $userHRD->id_user,
            'id_divisi'     => $divHRD->id_divisi,
            'nik'           => 'HRD-001',
            'nama_lengkap'  => 'Siti Aminah, S.Psi',
            'jenis_kelamin' => 'P',           // Wajib: L/P
            'tanggal_lahir' => '1990-05-15',  // Wajib
            'alamat'        => 'Jl. Sudirman No. 1, Jakarta', // Wajib
            'tanggal_masuk' => '2015-02-10',  // Wajib
            // foto (nullable) -> SKIP
            'status'        => true,
        ]);

        // Set Manager untuk Divisi HRD
        $divHRD->update(['id_manajer' => $userHRD->id_user]);


        // =====================================================================
        // BAGIAN 2: DIVISI & KARYAWAN LAIN
        // =====================================================================

        $listDivisi = ['IT Development', 'Finance', 'Marketing', 'Operasional'];
        $counter = 1;

        foreach ($listDivisi as $namaDivisi) {
            
            // 2.1 Buat Divisi
            $divisi = Divisi::create([
                'nama_divisi' => $namaDivisi,
                'status'      => true,
            ]);

            // --- A. BUAT MANAGER ---
            $slug = strtolower(explode(' ', $namaDivisi)[0]); // Ambil kata pertama utk email (it, finance, dll)
            
            $userManager = User::create([
                'name'     => 'Manager ' . $namaDivisi,
                'email'    => $slug . '.mgr@kantor.com',
                'password' => $passwordDefault,
                'role'     => 'Manajer',
                'status'   => true,
            ]);

            Karyawan::create([
                'id_user'       => $userManager->id_user,
                'id_divisi'     => $divisi->id_divisi,
                'nik'           => strtoupper(substr($slug, 0, 3)) . '-001',
                'nama_lengkap'  => 'Budi ' . $namaDivisi, // Nama Dummy
                'jenis_kelamin' => 'L',
                'tanggal_lahir' => '1985-08-17',
                'alamat'        => 'Jl. Kebon Jeruk No. ' . $counter,
                'tanggal_masuk' => '2018-01-01',
                'status'        => true,
            ]);

            // Update Divisi dengan ID Manager
            $divisi->update(['id_manajer' => $userManager->id_user]);


            // --- B. BUAT STAFF (2 Orang per Divisi) ---
            for ($i = 1; $i <= 2; $i++) {
                $userStaff = User::create([
                    'name'     => 'Staff ' . $namaDivisi . ' ' . $i,
                    'email'    => $slug . '.staff' . $i . '@kantor.com',
                    'password' => $passwordDefault,
                    'role'     => 'Karyawan',
                    'status'   => true,
                ]);

                Karyawan::create([
                    'id_user'       => $userStaff->id_user,
                    'id_divisi'     => $divisi->id_divisi,
                    'nik'           => strtoupper(substr($slug, 0, 3)) . '-00' . ($i + 1),
                    'nama_lengkap'  => 'Andi Staff ' . $namaDivisi . ' ' . $i,
                    'jenis_kelamin' => ($i % 2 == 0) ? 'P' : 'L', // Selang seling L/P
                    'tanggal_lahir' => '1995-0' . $i . '-20',
                    'alamat'        => 'Jl. Merdeka No. ' . ($counter + $i),
                    'tanggal_masuk' => '2021-06-15',
                    'status'        => true,
                ]);
            }

            $counter += 5; // Biar alamat beda-beda dikit
        }
    }
}