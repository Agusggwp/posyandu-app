<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PemeriksaanIbuHamil extends Model
{
    protected $fillable = [
        'ibu_hamil_id',
        'user_id',
        'tanggal_pemeriksaan',
        'usia_kehamilan',
        'tekanan_darah',
        'berat_badan',
        'lingkar_lengan_atas',
        'tinggi_fundus',
        'denyut_jantung_janin',
        'catatan'
    ];

    protected $casts = [
        'tanggal_pemeriksaan' => 'date',
    ];

    public function ibuHamil()
    {
        return $this->belongsTo(IbuHamil::class);
    }

    public function petugas()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
