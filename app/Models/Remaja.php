<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Remaja extends Model
{
    protected $table = 'remaja_identitas';

    protected $fillable = [
        'kepala_keluarga_id',
        'nama_anak',
        'nik',
        'tanggal_lahir',
        'jenis_kelamin',
        'nama_ortu',
        'no_hp',
        'riwayat_keluarga',
        'riwayat_diri',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    public function keluarga()
    {
        return $this->belongsTo(Keluarga::class, 'kepala_keluarga_id');
    }

    public function pemeriksaans()
    {
        return $this->hasMany(PemeriksaanRemaja::class, 'remaja_identitas_id');
    }
}
