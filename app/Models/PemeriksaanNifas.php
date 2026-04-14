<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PemeriksaanNifas extends Model
{
    protected $table = 'nifas_pemeriksaan';

    protected $fillable = [
        'nifas_identitas_id',
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
        'vitamin_a',
        'menyusui',
        'kb',
        'edukasi',
        'rujukan',
    ];

    public function nifas()
    {
        return $this->belongsTo(Nifas::class, 'nifas_identitas_id');
    }
}
