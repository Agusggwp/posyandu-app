<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Keluarga extends Authenticatable
{
    protected $table = 'kepala_keluarga';

    protected $fillable = [
        'no_kk',
        'nama_lengkap',
        'email',
        'password',
        'no_nik',
        'alamat',
        'no_telepon',
        'email_verified_at',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function balitas()
    {
        return $this->hasMany(Balita::class, 'kepala_keluarga_id');
    }

    public function ibuHamils()
    {
        return $this->hasMany(IbuHamil::class, 'kepala_keluarga_id');
    }

    public function lansias()
    {
        return $this->hasMany(Lansia::class, 'kepala_keluarga_id');
    }

    public function nifases()
    {
        return $this->hasMany(Nifas::class, 'kepala_keluarga_id');
    }

    public function remajas()
    {
        return $this->hasMany(Remaja::class, 'kepala_keluarga_id');
    }

    public function getNamaKepalaKeluargaAttribute(): string
    {
        return $this->nama_lengkap ?? '';
    }

    public function getTeleponAttribute(): ?string
    {
        return $this->no_telepon;
    }

    public function getRtAttribute(): ?string
    {
        return null;
    }

    public function getRwAttribute(): ?string
    {
        return null;
    }

    public function getKelurahanAttribute(): ?string
    {
        return null;
    }

    public function getKecamatanAttribute(): ?string
    {
        return null;
    }
}
