<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('spds', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat')->unique();
            
            // 1. Buat kolom foreign key
            $table->unsignedBigInteger('spt_id');
            $table->unsignedBigInteger('pegawai_id');
            $table->unsignedBigInteger('kuasa_anggaran_id');

            // 2. Definisikan relasi secara manual agar sesuai dengan nama tabel di database Anda
            $table->foreign('spt_id')->references('id')->on('spt')->onDelete('cascade');
            $table->foreign('pegawai_id')->references('id')->on('pegawai')->onDelete('cascade');
            $table->foreign('kuasa_anggaran_id')->references('id')->on('pegawai')->onDelete('cascade');
            
            $table->string('tingkat_biaya'); 
            $table->string('alat_angkut');   
            $table->string('tempat_berangkat')->default('Medan');
            $table->string('tempat_tujuan');
            $table->string('skpd')->default('Dinas Ketahanan Pangan, Tanaman Pangan dan Hortikultura Provsu');
            $table->string('kode_rekening'); 
            $table->text('keterangan_lain')->nullable();
            $table->date('tgl_dikeluarkan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('spds');
    }
};
