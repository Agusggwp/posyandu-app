<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Balita extends Model
{
    protected $table = 'balita_identitas';

    protected $fillable = [
        'kepala_keluarga_id',
        'nama_bayi',
        'nik',
        'jenis_kelamin',
        'tanggal_lahir',
        'berat_badan_lahir',
        'panjang_badan_lahir',
        'nama_ortu',
        'no_hp',
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
        return $this->hasMany(PemeriksaanBalita::class, 'balita_identitas_id');
    }

    public function getKeluargaIdAttribute(): ?int
    {
        return $this->kepala_keluarga_id;
    }

    public function getNamaAttribute(): string
    {
        return $this->nama_bayi ?? '';
    }

    public function getBeratLahirAttribute()
    {
        return $this->berat_badan_lahir;
    }

    public function getTinggiLahirAttribute()
    {
        return $this->panjang_badan_lahir;
    }

    public function getNamaAyahAttribute(): ?string
    {
        return $this->nama_ortu;
    }

    public function getNamaIbuAttribute(): ?string
    {
        return $this->nama_ortu;
    }

    public function getNamaOrangtuaAttribute(): ?string
    {
        return $this->nama_ortu;
    }
}
