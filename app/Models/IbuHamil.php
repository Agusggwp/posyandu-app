<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IbuHamil extends Model
{
    protected $fillable = [
        'keluarga_id',
        'nama',
        'nik',
        'tanggal_lahir',
        'nama_suami',
        'hpht',
        'hpl',
        'hamil_ke'
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'hpht' => 'date',
        'hpl' => 'date',
    ];

    public function keluarga()
    {
        return $this->belongsTo(Keluarga::class);
    }

    public function pemeriksaans()
    {
        return $this->hasMany(PemeriksaanIbuHamil::class);
    }
}
