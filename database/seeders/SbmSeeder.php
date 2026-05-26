<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // <-- TAMBAHKAN BARIS INI

class SbmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('sbm_sumut')->insert([
            [
                'jenis_biaya' => 'Penginapan',
                'golongan_atau_eselon' => 'Eselon III / Gol II & III',
                'lokasi_tujuan' => 'DKI Jakarta',
                'batas_maksimal' => 1500000, 
            ],
            [
                'jenis_biaya' => 'Uang Harian',
                'golongan_atau_eselon' => 'Semua Golongan',
                'lokasi_tujuan' => 'Luar Kota (Sumut)',
                'batas_maksimal' => 430000,
            ]
        ]);
    }
}