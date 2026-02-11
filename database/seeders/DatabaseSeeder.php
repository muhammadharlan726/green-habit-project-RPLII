<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; // Penting: Untuk enkripsi password
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Buat Akun ADMIN (Super Admin)
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@green.com',
            'password' => Hash::make('admin123'), // Password yang dienkripsi
            'role' => 'admin',     // Hak akses Admin
            'status' => 'active',
            'points' => 9999,      // Poin modal awal
            'streak' => 0,
        ]);

        // 2. Buat Akun USER BIASA (Untuk Testing)
        User::create([
            'name' => 'Budi Santoso',
            'email' => 'user@green.com',
            'password' => Hash::make('user123'),
            'role' => 'user',      // Hak akses User biasa
            'status' => 'active',
            'points' => 0,
            'streak' => 0,
        ]);

        // (Opsional) Jika Anda ingin membuat 10 user acak tambahan,
        // barulah kita pakai factory bawaan tadi:
        // User::factory(10)->create();
    }
}