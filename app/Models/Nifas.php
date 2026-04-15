<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nifas extends Model
{
    protected $table = 'nifas_identitas';

    protected $fillable = [
        'kepala_keluarga_id',
        'nama_ibu',
        'nik',
        'tanggal_lahir',
        'umur',
        'nama_suami',
        'no_hp',
        'tanggal_bersalin',
        'tempat_bersalin',
        'anak_ke',
        'tinggi_badan_ibu',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_bersalin' => 'date',
    ];

    public function keluarga()
    {
        return $this->belongsTo(Keluarga::class, 'kepala_keluarga_id');
    }

    public function pemeriksaans()
    {
        return $this->hasMany(PemeriksaanNifas::class, 'nifas_identitas_id');
    }
}
