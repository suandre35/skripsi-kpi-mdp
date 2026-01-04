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
            'name'     => 'Arif Yulianto',
            'email'    => 'hrd.mgr@kantor.com',
            'password' => $passwordDefault,
            'role'     => 'HRD', 
            'status'   => true,
        ]);

        Karyawan::create([
            'id_user'       => $userMgrHRD->id_user,
            'id_divisi'     => $divHRD->id_divisi,
            'nik'           => 'HRD-MGR',
            'nama_lengkap'  => 'Arif Yulianto, S.Kom.,MTI',
            'jenis_kelamin' => 'L',
            
            // Biodata
            'tempat_lahir'  => 'Palembang',
            'tanggal_lahir' => '1985-01-01',
            'alamat'        => 'Jl. Sudirman No. 1, Palembang',
            'no_telepon'    => '081211110001',
            'email'         => 'arifyulianto@mail.com',

            'tanggal_masuk' => '2012-01-01',
            'status'        => true,
        ]);

        // Set Manager untuk Divisi HRD
        $divHRD->update(['id_manajer' => $userMgrHRD->id_user]);
    }
}