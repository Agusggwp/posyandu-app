<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lansia extends Model
{
    protected $table = 'dewasa_identitas';

    protected $fillable = [
        'kepala_keluarga_id',
        'nama',
        'nik',
        'tanggal_lahir',
        'umur',
        'alamat',
        'no_hp',
        'status_perkawinan',
        'pekerjaan',
        'dusun',
        'desa',
        'kecamatan',
        'riwayat_keluarga',
        'riwayat_diri',
        'merokok',
        'konsumsi_gula',
        'konsumsi_garam',
        'konsumsi_lemak',
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
        return $this->hasMany(PemeriksaanLansia::class, 'dewasa_identitas_id');
    }

    public function getKeluargaIdAttribute(): ?int
    {
        return $this->kepala_keluarga_id;
    }

    public function getRiwayatPenyakitAttribute(): ?string
    {
        return $this->riwayat_diri;
    }
}
