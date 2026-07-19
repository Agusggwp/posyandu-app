<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PemeriksaanBalita extends Model
{
    protected $table = 'balita_pemeriksaan';

    protected $fillable = [
        'balita_identitas_id',
        'tahap_terakhir',
        'tanggal_kunjungan',
        'tanggal_pemeriksaan',
        'umur',
        'waktu_kunjungan',
        'berat_badan',
        'naik_tidak_naik',
        'status_bb_u',
        'panjang_badan',
        'status_pb_u',
        'status_bb_pb',
        'status_lila',
        'lingkar_lengan',
        'lingkar_kepala',
        'batuk',
        'demam',
        'bb_turun',
        'kontak_tbc',
        'perkembangan',
        'asi_eksklusif',
        'mpasi',
        'imunisasi',
        'jenis_imunisasi',
        'vitamin_a',
        'obat_cacing',
        'mt_pangan',
        'edukasi',
        'catatan_kesehatan',
        'rujukan',
    ];

    protected $casts = [
        'tanggal_kunjungan' => 'date',
        'tanggal_pemeriksaan' => 'date',
        'waktu_kunjungan' => 'datetime',
        'batuk' => 'boolean',
        'demam' => 'boolean',
        'bb_turun' => 'boolean',
        'kontak_tbc' => 'boolean',
    ];

    public function balita()
    {
        return $this->belongsTo(Balita::class, 'balita_identitas_id');
    }

    public function getStatusGiziAttribute()
    {
        if (in_array($this->status_pb_u, ['SP', 'P', 'Sangat Pendek', 'Pendek'])) {
            return 'stunting';
        }
        if (in_array($this->status_bb_pb, ['K', 'Kurang', 'Buruk']) || 
            in_array($this->status_bb_u, ['SK', 'K', 'Sangat Kurang', 'Kurang'])) {
            return 'kurang';
        }
        if (in_array($this->status_bb_pb, ['B', 'Normal', 'Baik', 'Gizi Baik']) || 
            in_array($this->status_bb_u, ['N', 'Normal']) || 
            in_array($this->status_pb_u, ['N', 'Normal', 'Tinggi'])) {
            return 'normal';
        }
        return 'normal';
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
