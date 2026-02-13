<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keluarga extends Model
{
    protected $fillable = [
        'no_kk',
        'nama_kepala_keluarga',
        'alamat',
        'rt',
        'rw',
        'kelurahan',
        'kecamatan',
        'telepon'
    ];

    public function balitas()
    {
        return $this->hasMany(Balita::class);
    }

    public function ibuHamils()
    {
        return $this->hasMany(IbuHamil::class);
    }

    public function lansias()
    {
        return $this->hasMany(Lansia::class);
    }
}
