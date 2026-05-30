<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('spt', function (Blueprint $table) {
            // 1. Tambahkan kolom foreign key (nullable agar data lama aman)
            $table->unsignedBigInteger('pejabat_ttd_id')->nullable()->after('id');

            // 2. Definisikan relasi ke tabel pegawai
            $table->foreign('pejabat_ttd_id')->references('id')->on('pegawai')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('spt', function (Blueprint $table) {
            // Hapus relasi dan kolom jika migration di-rollback
            $table->dropForeign(['pejabat_ttd_id']);
            $table->dropColumn('pejabat_ttd_id');
        });
    }
};