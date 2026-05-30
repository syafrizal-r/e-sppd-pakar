<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SpdPengikut extends Model
{
    protected $table = 'spd_pengikut';
    protected $guarded = ['id'];

    // Menghubungkan pengikut kembali ke data master pegawai (untuk mengambil NIP / Tgl Lahir)
    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }
}