<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PemeriksaanLansia extends Model
{
    protected $table = 'dewasa_pemeriksaan';

    protected $fillable = [
        'dewasa_identitas_id',
        'waktu_kunjungan',
        'tanggal_kunjungan',
        'tanggal_pemeriksaan',
        'berat_badan',
        'tinggi_badan',
        'imt',
        'status_berat_badan',
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
        'tahap_terakhir',
    ];

    protected $casts = [
        'tanggal_kunjungan' => 'date',
        'tanggal_pemeriksaan' => 'date',
        'waktu_kunjungan' => 'datetime',
        'batuk' => 'boolean',
        'demam' => 'boolean',
        'bb_turun' => 'boolean',
        'kontak_tbc' => 'boolean',
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
