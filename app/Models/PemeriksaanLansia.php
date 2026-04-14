<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PemeriksaanLansia extends Model
{
    protected $table = 'dewasa_pemeriksaan';

    protected $fillable = [
        'dewasa_identitas_id',
        'waktu_kunjungan',
        'berat_badan',
        'tinggi_badan',
        'imt',
        'lingkar_perut',
        'sistole',
        'diastole',
        'tekanan_darah_status',
        'gula_darah',
        'mata_kanan',
        'mata_kiri',
        'telinga_kanan',
        'telinga_kiri',
        'jenis_kelamin',
        'usia_kategori',
        'skor_merokok',
        'napas_berat',
        'dahak',
        'batuk',
        'aktivitas_terganggu',
        'pemeriksaan_sebelumnya',
        'skor_puma',
        'batuk_tbc',
        'demam',
        'bb_turun',
        'kontak_tbc',
        'edukasi',
        'rujukan',
    ];

    protected $casts = [
        'waktu_kunjungan' => 'datetime',
        'napas_berat' => 'boolean',
        'dahak' => 'boolean',
        'batuk' => 'boolean',
        'aktivitas_terganggu' => 'boolean',
        'batuk_tbc' => 'boolean',
        'demam' => 'boolean',
        'bb_turun' => 'boolean',
        'kontak_tbc' => 'boolean',
    ];

    public function lansia()
    {
        return $this->belongsTo(Lansia::class, 'dewasa_identitas_id');
    }
}
