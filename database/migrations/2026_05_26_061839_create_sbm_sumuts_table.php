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
        Schema::create('sbm_sumut', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_biaya'); // Contoh: 'Uang Harian', 'Penginapan'
            $table->string('golongan_atau_eselon')->nullable(); // 'Golongan I/II', 'Eselon III'
            $table->string('lokasi_tujuan'); // 'Dalam Kota', 'Luar Kota', 'DKI Jakarta'
            $table->integer('batas_maksimal'); // Angka SBM
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sbm_sumuts');
    }
};
