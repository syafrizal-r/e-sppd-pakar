<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Ambil data dari tabel lama
        $dataLama = DB::table('pengajuan_spj')->get();

        foreach ($dataLama as $item) {
            DB::table('kuitansi')->insert([
                // Kita isi null karena tabel lama tidak punya relasi SPD
                'spd_id' => null, 
                // Gunakan nomor_kuitansi acak/sementara jika tabel lama tidak punya
                'nomor_kuitansi' => 'KWT-' . $item->id . '-' . date('Y'), 
                'jumlah_uang' => $item->nominal_diajukan, // Diambil dari hasil listing Anda
                'untuk_pembayaran' => 'Pembayaran ' . $item->jenis_biaya_diajukan . ' - ' . $item->tujuan_dinas,
                'tanggal_kuitansi' => $item->created_at,
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
            ]);
        }
    }

    public function down(): void
    {
        // Kosongkan tabel kuitansi jika rollback
        DB::table('kuitansi')->truncate();
    }
};