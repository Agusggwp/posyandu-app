<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PemeriksaanBalita extends Model
{
    protected $fillable = [
        'balita_id',
        'user_id',
        'tanggal_pemeriksaan',
        'berat_badan',
        'tinggi_badan',
        'lingkar_kepala',
        'imunisasi',
        'vitamin',
        'status_gizi',
        'catatan'
    ];

    protected $casts = [
        'tanggal_pemeriksaan' => 'date',
    ];

    public function balita()
    {
        return $this->belongsTo(Balita::class);
    }

    public function petugas()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
