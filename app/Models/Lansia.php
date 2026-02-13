<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lansia extends Model
{
    protected $fillable = [
        'keluarga_id',
        'nama',
        'nik',
        'jenis_kelamin',
        'tanggal_lahir',
        'riwayat_penyakit'
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    public function keluarga()
    {
        return $this->belongsTo(Keluarga::class);
    }

    public function pemeriksaans()
    {
        return $this->hasMany(PemeriksaanLansia::class);
    }
}
