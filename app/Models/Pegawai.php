<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    // Mendefinisikan nama tabel secara eksplisit
    protected $table = 'pegawai';

    // Mengizinkan semua kolom diisi secara massal (Mass Assignment)
    protected $guarded = [];
}
