<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PemeriksaanLansia extends Model
{
    protected $fillable = [
        'lansia_id',
        'user_id',
        'tanggal_pemeriksaan',
        'tekanan_darah',
        'berat_badan',
        'tinggi_badan',
        'gula_darah',
        'kolesterol',
        'keluhan',
        'catatan'
    ];

    protected $casts = [
        'tanggal_pemeriksaan' => 'date',
    ];

    public function lansia()
    {
        return $this->belongsTo(Lansia::class);
    }

    public function petugas()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
