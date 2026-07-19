<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PemeriksaanRemaja extends Model
{
    protected $table = 'remaja_pemeriksaan';

    protected $fillable = [
        'remaja_identitas_id',
        'waktu_kunjungan',
        'tanggal_kunjungan',
        'tahap_terakhir',
        'berat_badan',
        'tinggi_badan',
        'imt_status',
        'lingkar_perut',
        'sistole',
        'diastole',
        'tekanan_darah_status',
        'gula_darah',
        'hemoglobin',
        'anemia',
        'batuk',
        'demam',
        'bb_turun',
        'kontak_tbc',
        'masalah_rumah',
        'masalah_pendidikan',
        'masalah_makan',
        'masalah_aktivitas',
        'masalah_obat',
        'masalah_seksual',
        'masalah_emosi',
        'masalah_keamanan',
        'edukasi',
        'rujukan',
    ];

    protected $casts = [
        'waktu_kunjungan' => 'datetime',
        'tanggal_kunjungan' => 'date',
        'batuk' => 'boolean',
        'demam' => 'boolean',
        'bb_turun' => 'boolean',
        'kontak_tbc' => 'boolean',
        'anemia' => 'boolean',
    ];

    public function remaja()
    {
        return $this->belongsTo(Remaja::class, 'remaja_identitas_id');
    }

    protected static function booted()
    {
        static::saving(function ($model) {
            if (empty($model->waktu_kunjungan) && !empty($model->tanggal_kunjungan)) {
                $model->waktu_kunjungan = $model->tanggal_kunjungan;
            } elseif (empty($model->tanggal_kunjungan) && !empty($model->waktu_kunjungan)) {
                $model->tanggal_kunjungan = $model->waktu_kunjungan;
            }
        });
    }
}
