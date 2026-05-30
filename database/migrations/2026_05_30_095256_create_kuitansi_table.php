<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kuitansi', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke SPD (Kuitansi milik SPD mana?)
            $table->unsignedBigInteger('spd_id');
            
            // Kolom Pejabat Penandatangan
            $table->unsignedBigInteger('pejabat_ttd_id')->nullable();
            $table->unsignedBigInteger('bendahara_id')->nullable();
            
            // Informasi Kuitansi
            $table->string('nomor_kuitansi')->unique();
            $table->decimal('jumlah_uang', 15, 2);
            $table->text('untuk_pembayaran');
            $table->date('tanggal_kuitansi');
            
            $table->timestamps();

            // Foreign Keys
            $table->foreign('spd_id')->references('id')->on('spds')->onDelete('cascade');
            $table->foreign('pejabat_ttd_id')->references('id')->on('pegawai')->onDelete('set null');
            $table->foreign('bendahara_id')->references('id')->on('pegawai')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kuitansi');
    }
};