<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Spt extends Model
{
    protected $table = 'spt';
    protected $guarded = [];

    // Relasi Many-to-Many: Satu SPT memiliki banyak Pegawai
    public function pegawai()
    {
        return $this->belongsToMany(Pegawai::class, 'spt_pegawai', 'spt_id', 'pegawai_id');
    }
}