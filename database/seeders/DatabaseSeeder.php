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

        $passwordDefault = Hash::make('password'); // Password default: password

        // =====================================================================
        // 1. SETUP DIVISI HRD (Role: HRD & Karyawan)
        // =====================================================================
        $divHRD = Divisi::create([
            'nama_divisi' => 'HRD',
            'status'      => true,
        ]);

        // A. Manager HRD (Role: HRD)
        $userMgrHRD = User::create([
            'name'     => 'Manager HRD',
            'email'    => 'hrd.mgr@kantor.com',
            'password' => $passwordDefault,
            'role'     => 'HRD', // Role khusus Admin/HRD
            'status'   => true,
        ]);

        Karyawan::create([
            'id_user'       => $userMgrHRD->id_user,
            'id_divisi'     => $divHRD->id_divisi,
            'nik'           => 'HRD-MGR',
            'nama_lengkap'  => 'Siti Aminah, S.Psi',
            'jenis_kelamin' => 'P',
            'tanggal_lahir' => '1985-05-15',
            'alamat'        => 'Jl. Sudirman No. 1, Jakarta',
            'tanggal_masuk' => '2015-02-10',
            'status'        => true,
        ]);

        // Set Manager untuk Divisi HRD
        $divHRD->update(['id_manajer' => $userMgrHRD->id_user]);

        // B. Staff HRD (Role: Karyawan)
        $userStaffHRD = User::create([
            'name'     => 'Staff HRD',
            'email'    => 'hrd.staff@kantor.com',
            'password' => $passwordDefault,
            'role'     => 'Karyawan',
            'status'   => true,
        ]);

        Karyawan::create([
            'id_user'       => $userStaffHRD->id_user,
            'id_divisi'     => $divHRD->id_divisi,
            'nik'           => 'HRD-STF-01',
            'nama_lengkap'  => 'Dina Staff HRD',
            'jenis_kelamin' => 'P',
            'tanggal_lahir' => '1998-03-12',
            'alamat'        => 'Jl. Mawar No. 10, Jakarta',
            'tanggal_masuk' => '2022-01-15',
            'status'        => true,
        ]);


        // =====================================================================
        // 2. SETUP DIVISI LAINNYA (Logistik, Keuangan, Accounting, Service, Store)
        // =====================================================================
        
        $listDivisi = ['Logistik', 'Keuangan', 'Accounting', 'Service', 'Store'];
        $counter = 1;

        foreach ($listDivisi as $namaDivisi) {
            
            // Buat Divisi
            $divisi = Divisi::create([
                'nama_divisi' => $namaDivisi,
                'status'      => true,
            ]);

            // Slug untuk email & nik (misal: Logistik -> logistik)
            $slug = strtolower($namaDivisi);
            $kodeNik = strtoupper(substr($namaDivisi, 0, 3)); // LOG, KEU, ACC, SER, STO

            // --- A. MANAGER (Role: Manajer) ---
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
                'nik'           => $kodeNik . '-MGR',
                'nama_lengkap'  => 'Budi Manager ' . $namaDivisi,
                'jenis_kelamin' => 'L',
                'tanggal_lahir' => '1980-08-17',
                'alamat'        => 'Jl. Kebon Jeruk No. ' . $counter,
                'tanggal_masuk' => '2016-01-01',
                'status'        => true,
            ]);

            // Update Divisi dengan ID Manager
            $divisi->update(['id_manajer' => $userManager->id_user]);


            // --- B. STAFF (Role: Karyawan) - Buat 2 staff per divisi ---
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
                    'nik'           => $kodeNik . '-STF-0' . $i,
                    'nama_lengkap'  => 'Andi Staff ' . $namaDivisi . ' ' . $i,
                    'jenis_kelamin' => ($i % 2 == 0) ? 'P' : 'L',
                    'tanggal_lahir' => '1995-0' . $i . '-20',
                    'alamat'        => 'Jl. Merdeka No. ' . ($counter + $i),
                    'tanggal_masuk' => '2021-06-15',
                    'status'        => true,
                ]);
            }

            $counter += 5;
        }
    }
}