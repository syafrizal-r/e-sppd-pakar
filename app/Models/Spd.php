<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Spd extends Model
{
    protected $guarded = ['id'];

    // Relasi ke tabel SPT (untuk mengambil maksud tujuan & lama hari)
    public function SampleSpt(): BelongsTo
    {
        return $this->belongsTo(Spt::class, 'spt_id');
    }

    // Relasi mengambil data Pegawai yang berangkat
    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }

    // Relasi mengambil Pejabat/KPA yang tanda tangan
    public function kuasaAnggaran(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class, 'kuasa_anggaran_id');
    }

    // Relasi untuk mendapatkan semua pengikut di surat ini
    public function pengikut(): HasMany
    {
        return $this->hasMany(SpdPengikut::class, 'spd_id');
    }
}