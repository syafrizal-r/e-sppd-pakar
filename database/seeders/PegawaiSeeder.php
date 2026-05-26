<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PegawaiSeeder extends Seeder
{
    public function run()
    {
        DB::table('pegawai')->insert([
            [
                'nama' => 'Ir. Budi Santoso, M.Si',
                'nip' => '197508122001121004',
                'pangkat' => 'Pembina Tingkat I',
                'golongan' => 'IV/b',
                'jabatan' => 'Kepala Bidang Tanaman Pangan'
            ],
            [
                'nama' => 'Siti Aminah, S.P., M.M.',
                'nip' => '198203242008012011',
                'pangkat' => 'Penata Tingkat I',
                'golongan' => 'III/d',
                'jabatan' => 'Penyuluh Pertanian Madya'
            ],
            [
                'nama' => 'Ahmad Fauzi, S.Kom',
                'nip' => '199011152015031002',
                'pangkat' => 'Penata Muda Tingkat I',
                'golongan' => 'III/b',
                'jabatan' => 'Pranata Komputer Ahli Pertama'
            ]
        ]);
    }
}
