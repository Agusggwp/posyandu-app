<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PemeriksaanNifas extends Model
{
    protected $table = 'nifas_pemeriksaan';

    protected $fillable = [
        'nifas_identitas_id',
        'tahap_terakhir',
        'tanggal_kunjungan',
        'waktu_kunjungan',
        'berat_badan',
        'naik_turun',
        'tinggi_badan',
        'lila',
        'status_gizi',
        'sistole',
        'diastole',
        'tekanan_darah_status',
        'batuk',
        'demam',
        'bb_turun',
        'kontak_tbc',
        'status_tbc',
        'vitamin_a',
        'menyusui',
        'kb',
        'edukasi',
        'rujukan',
    ];

    protected $casts = [
        'tanggal_kunjungan' => 'date',
        'waktu_kunjungan' => 'datetime',
    ];

    public function nifas()
    {
        return $this->belongsTo(Nifas::class, 'nifas_identitas_id');
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
