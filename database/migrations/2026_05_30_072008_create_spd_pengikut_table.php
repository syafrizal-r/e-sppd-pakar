<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('spd_pengikut', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('spd_id');
            $table->unsignedBigInteger('pegawai_id');

            // Relasi ke tabel spds dan pegawai (tanpa 's')
            $table->foreign('spd_id')->references('id')->on('spds')->onDelete('cascade');
            $table->foreign('pegawai_id')->references('id')->on('pegawai')->onDelete('cascade');

            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('spd_pengikut');
    }
};
