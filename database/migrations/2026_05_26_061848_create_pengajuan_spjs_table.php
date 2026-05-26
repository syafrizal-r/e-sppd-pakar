<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('pengajuan_spj', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pegawai');
            $table->string('golongan'); // 'Golongan III'
            $table->string('tujuan_dinas'); // 'DKI Jakarta'
            $table->string('jenis_biaya_diajukan'); // 'Penginapan'
            $table->integer('nominal_diajukan'); // Biaya riil di kuitansi

            // Output dari Sistem Pakar
            $table->string('status_verifikasi')->default('Menunggu Evaluasi');
            $table->text('pesan_sistem')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_spjs');
    }
};
