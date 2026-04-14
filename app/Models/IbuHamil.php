<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IbuHamil extends Model
{
    protected $table = 'ibu_hamil_identitas';

    protected $fillable = [
        'kepala_keluarga_id',
        'nik',
        'nama_ibu',
        'tanggal_lahir',
        'umur',
        'nama_suami',
        'alamat',
        'no_hp',
        'l_ibu_hamil',
        'kehamilan_ke',
        'jarak_anak_sebelumnya',
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
        return $this->hasMany(PemeriksaanIbuHamil::class, 'ibu_hamil_identitas_id');
    }

    public function getKeluargaIdAttribute(): ?int
    {
        return $this->kepala_keluarga_id;
    }

    public function getNamaAttribute(): string
    {
        return $this->nama_ibu ?? '';
    }

    public function getHamilKeAttribute()
    {
        return $this->kehamilan_ke;
    }

    public function getHphtAttribute()
    {
        return $this->tanggal_kunjungan;
    }

    public function getHplAttribute()
    {
        return $this->tanggal_kunjungan;
    }
}
