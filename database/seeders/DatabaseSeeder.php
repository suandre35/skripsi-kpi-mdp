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
        $this->command->info('🧹 Membersihkan database lama...');
        Schema::disableForeignKeyConstraints();
        Karyawan::truncate();
        Divisi::truncate();
        User::truncate();
        Schema::enableForeignKeyConstraints();

        $passwordDefault = Hash::make('password'); // Password default: password

        // =====================================================================
        // 1. SETUP DIVISI HRD (Role: HRD & Karyawan)
        // =====================================================================
        $this->command->info('👤 Membuat Akun HRD & Manager HRD...');
        
        $divHRD = Divisi::create([
            'nama_divisi' => 'HRD',
            'status'      => true,
        ]);

        // A. Manager HRD (Role: HRD) - Nama: Rina Kusuma
        $userMgrHRD = User::create([
            'name'     => 'Rina Kusuma, S.Psi',
            'email'    => 'hrd.mgr@kantor.com',
            'password' => $passwordDefault,
            'role'     => 'HRD', 
            'status'   => true,
        ]);

        Karyawan::create([
            'id_user'       => $userMgrHRD->id_user,
            'id_divisi'     => $divHRD->id_divisi,
            'nik'           => 'HRD-MGR',
            'nama_lengkap'  => 'Rina Kusuma, S.Psi',
            'jenis_kelamin' => 'P',
            
            // Biodata
            'tempat_lahir'  => 'Jakarta',
            'tanggal_lahir' => '1985-05-15',
            'alamat'        => 'Jl. Sudirman No. 1, Jakarta Selatan',
            'no_telepon'    => '081211110001',
            'email'         => 'rina.kusuma@pribadi.com',

            'tanggal_masuk' => '2015-02-10',
            'status'        => true,
        ]);

        // Set Manager untuk Divisi HRD
        $divHRD->update(['id_manajer' => $userMgrHRD->id_user]);

        // B. Staff HRD (Role: Karyawan) - Nama: Dimas Anggara
        $userStaffHRD = User::create([
            'name'     => 'Dimas Anggara',
            'email'    => 'hrd.staff@kantor.com',
            'password' => $passwordDefault,
            'role'     => 'Karyawan',
            'status'   => true,
        ]);

        Karyawan::create([
            'id_user'       => $userStaffHRD->id_user,
            'id_divisi'     => $divHRD->id_divisi,
            'nik'           => 'HRD-STF-01',
            'nama_lengkap'  => 'Dimas Anggara',
            'jenis_kelamin' => 'L',
            
            // Biodata
            'tempat_lahir'  => 'Bandung',
            'tanggal_lahir' => '1998-03-12',
            'alamat'        => 'Jl. Mawar No. 10, Jakarta Barat',
            'no_telepon'    => '081211110002',
            'email'         => 'dimas.anggara@pribadi.com',

            'tanggal_masuk' => '2022-01-15',
            'status'        => true,
        ]);


        // =====================================================================
        // 2. SETUP DIVISI LAINNYA 
        // =====================================================================
        
        // Konfigurasi Nama Realistis untuk setiap divisi
        $divisiConfig = [
            'Logistik' => [
                'manager' => ['name' => 'Agus Santoso', 'jk' => 'L', 'lahir' => 'Surabaya'],
                'staff'   => [
                    ['name' => 'Bayu Nugraha', 'jk' => 'L', 'lahir' => 'Semarang'],
                    ['name' => 'Citra Lestari', 'jk' => 'P', 'lahir' => 'Solo']
                ]
            ],
            'Keuangan' => [
                'manager' => ['name' => 'Dewi Sartika, S.E', 'jk' => 'P', 'lahir' => 'Medan'],
                'staff'   => [
                    ['name' => 'Eko Prasetyo', 'jk' => 'L', 'lahir' => 'Yogyakarta'],
                    ['name' => 'Fani Rahmawati', 'jk' => 'P', 'lahir' => 'Magelang']
                ]
            ],
            'Accounting' => [
                'manager' => ['name' => 'Gilang Ramadhan, Ak', 'jk' => 'L', 'lahir' => 'Jakarta'],
                'staff'   => [
                    ['name' => 'Hesti Putri', 'jk' => 'P', 'lahir' => 'Bogor'],
                    ['name' => 'Indra Gunawan', 'jk' => 'L', 'lahir' => 'Depok']
                ]
            ],
            'Service' => [
                'manager' => ['name' => 'Joko Susilo', 'jk' => 'L', 'lahir' => 'Malang'],
                'staff'   => [
                    ['name' => 'Kiki Saputra', 'jk' => 'L', 'lahir' => 'Surabaya'],
                    ['name' => 'Luna Ardiana', 'jk' => 'P', 'lahir' => 'Bali']
                ]
            ],
            'Store' => [
                'manager' => ['name' => 'Maher Santoso', 'jk' => 'L', 'lahir' => 'Makassar'],
                'staff'   => [
                    ['name' => 'Nadine Amalia', 'jk' => 'P', 'lahir' => 'Palembang'],
                    ['name' => 'Oscar Pratama', 'jk' => 'L', 'lahir' => 'Lampung']
                ]
            ],
        ];

        $counter = 1;

        foreach ($divisiConfig as $namaDivisi => $personnel) {
            
            $this->command->info("🏢 Setup Divisi: {$namaDivisi}...");

            // Buat Divisi
            $divisi = Divisi::create([
                'nama_divisi' => $namaDivisi,
                'status'      => true,
            ]);

            // Slug & Kode
            $slug = strtolower($namaDivisi);
            $kodeNik = strtoupper(substr($namaDivisi, 0, 3)); 

            // --- A. MANAGER (Role: Manajer) ---
            $mgrData = $personnel['manager'];
            
            $userManager = User::create([
                'name'     => $mgrData['name'],
                'email'    => $slug . '.mgr@kantor.com', // Login tetap generic
                'password' => $passwordDefault,
                'role'     => 'Manajer',
                'status'   => true,
            ]);

            Karyawan::create([
                'id_user'       => $userManager->id_user,
                'id_divisi'     => $divisi->id_divisi,
                'nik'           => $kodeNik . '-MGR',
                'nama_lengkap'  => $mgrData['name'],
                'jenis_kelamin' => $mgrData['jk'],
                
                // Biodata
                'tempat_lahir'  => $mgrData['lahir'],
                'tanggal_lahir' => '1980-08-17',
                'alamat'        => 'Jl. Kebon Jeruk No. ' . $counter,
                'no_telepon'    => '0812999900' . $counter,
                'email'         => strtolower(str_replace([' ', '.', ','], '', $mgrData['name'])) . '@pribadi.com',

                'tanggal_masuk' => '2016-01-01',
                'status'        => true,
            ]);

            $divisi->update(['id_manajer' => $userManager->id_user]);


            // --- B. STAFF (Role: Karyawan) ---
            $i = 1;
            foreach ($personnel['staff'] as $stfData) {
                $userStaff = User::create([
                    'name'     => $stfData['name'],
                    'email'    => $slug . '.staff' . $i . '@kantor.com', // Login tetap generic
                    'password' => $passwordDefault,
                    'role'     => 'Karyawan',
                    'status'   => true,
                ]);

                Karyawan::create([
                    'id_user'       => $userStaff->id_user,
                    'id_divisi'     => $divisi->id_divisi,
                    'nik'           => $kodeNik . '-STF-0' . $i,
                    'nama_lengkap'  => $stfData['name'],
                    'jenis_kelamin' => $stfData['jk'],
                    
                    // Biodata
                    'tempat_lahir'  => $stfData['lahir'],
                    'tanggal_lahir' => '1995-0' . $i . '-20',
                    'alamat'        => 'Jl. Merdeka No. ' . ($counter + $i),
                    'no_telepon'    => '08128888' . sprintf('%03d', $counter + $i),
                    'email'         => strtolower(str_replace(' ', '', $stfData['name'])) . '@pribadi.com',

                    'tanggal_masuk' => '2021-06-15',
                    'status'        => true,
                ]);
                $i++;
            }

            $counter += 5;
        }

        $this->command->info('✅ Database berhasil diisi dengan User, Divisi, dan Karyawan baru!');
    }
}