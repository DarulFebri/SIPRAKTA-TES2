<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,      // Pertama, buat semua user dasar
            DosenSeeder::class,     // Kedua, buat detail dosen
            MahasiswaSeeder::class, // Ketiga, buat detail mahasiswa
            // Tambahkan seeder lain jika ada
        ]);
    }
}