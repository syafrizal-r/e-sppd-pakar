<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kuitansi extends Model
{
    protected $table = 'kuitansi';
    protected $guarded = ['id'];

    public function spd() {
        return $this->belongsTo(Spd::class, 'spd_id');
    }

    public function pejabatTtd() {
        return $this->belongsTo(Pegawai::class, 'pejabat_ttd_id');
    }

    public function bendahara() {
        return $this->belongsTo(Pegawai::class, 'bendahara_id');
    }
}