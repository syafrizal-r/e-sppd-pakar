<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('spds', function (Blueprint $table) {
            // Tambahkan kolom pejabat_ttd_id setelah kolom kuasa_anggaran_id (nullable agar aman)
            $table->unsignedBigInteger('pejabat_ttd_id')->nullable()->after('kuasa_anggaran_id');

            // Definisikan relasi foreign key ke tabel pegawai
            $table->foreign('pejabat_ttd_id')->references('id')->on('pegawai')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('spds', function (Blueprint $table) {
            // Hapus relasi dan kolom jika di-rollback
            $table->dropForeign(['pejabat_ttd_id']);
            $table->dropColumn('pejabat_ttd_id');
        });
    }
};