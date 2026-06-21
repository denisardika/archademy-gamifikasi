<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 👥 1. Membuat Akun Akun Siswa Testing Otomatis
        User::factory()->create([
            'name' => 'Siswa Testing',
            'email' => 'siswa@example.com',
            'role' => 'siswa',
            'points' => 0,
            'rank' => 'Pemula',
        ]);

        // 👨‍🏫 2. Membuat Akun Guru Testing Otomatis
        User::factory()->create([
            'name' => 'Guru Admin',
            'email' => 'guru@example.com',
            'role' => 'guru',
            'points' => 0,
            'rank' => 'Master',
        ]);

        // 📚 3. Memicu Pemasukan Data Materi & Bank Soal Kuis
        $this->call([
            MateriSeeder::class,
            KuisSeeder::class, // <-- KuisSeeder sudah terdaftar dengan benar di sini
        ]);
    }
}