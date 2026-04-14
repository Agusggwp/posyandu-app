<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PemeriksaanRemaja extends Model
{
    protected $table = 'remaja_pemeriksaan';

    protected $fillable = [
        'remaja_identitas_id',
        'waktu_kunjungan',
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

    public function remaja()
    {
        return $this->belongsTo(Remaja::class, 'remaja_identitas_id');
    }
}
