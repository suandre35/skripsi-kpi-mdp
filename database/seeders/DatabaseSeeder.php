<?php

namespace Database\Seeders;

use App\Models\User;
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
        // User::factory(10)->create();

        User::create([
            'name' => 'Admin HRD',
            'email' => 'admin@mail.com',
            'password' => Hash::make('password'),
            'role' => 'HRD',
            'status' => 'aktif',
        ]);

        User::create([
            'name' => 'Manajer',
            'email' => 'manajer@mail.com',
            'password' => Hash::make('password'),
            'role' => 'Manajer',
            'status' => 'aktif',
        ]);

        User::create([
            'name' => 'Karyawan',
            'email' => 'karyawan@mail.com',
            'password' => Hash::make('password'),
            'role' => 'Karyawan',
            'status' => 'aktif',
        ]);
    }
}
