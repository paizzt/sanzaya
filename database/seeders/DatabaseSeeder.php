<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Membuat akun Admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@perusahaan.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        // Membuat akun Staff
        User::create([
            'name' => 'Staff Pegawai',
            'email' => 'staff@perusahaan.com',
            'password' => Hash::make('password123'),
            'role' => 'staff',
        ]);

        // Membuat akun Manager
        User::create([
            'name' => 'Manager Keuangan',
            'email' => 'manager@perusahaan.com',
            'password' => Hash::make('password123'),
            'role' => 'manager',
        ]);
    }
}