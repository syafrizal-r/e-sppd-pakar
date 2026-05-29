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
        // Memanggil UserSeeder agar akun Admin dimasukkan ke database
        $this->call([
            UserSeeder::class,
            
            // CATATAN: Jika Anda memiliki file seeder lain untuk SBM atau Pegawai, 
            // pastikan Anda juga menambahkannya di bawah ini, contoh:
            // SbmSeeder::class,
            // PegawaiSeeder::class,
        ]);
    }
}