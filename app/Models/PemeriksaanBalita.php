<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PemeriksaanBalita extends Model
{
    protected $table = 'balita_pemeriksaan';

    protected $fillable = [
        'balita_identitas_id',
        'umur',
        'waktu_kunjungan',
        'berat_badan',
        'naik_tidak_naik',
        'status_bb_u',
        'panjang_badan',
        'status_pb_u',
        'status_bb_pb',
        'lingkar_lengan',
        'status_lila',
        'lingkar_kepala',
        'batuk',
        'demam',
        'bb_turun',
        'kontak_tbc',
        'perkembangan',
        'asi_eksklusif',
        'mpasi',
        'imunisasi',
        'vitamin_a',
        'obat_cacing',
        'mt_pangan',
        'edukasi',
        'catatan_kesehatan',
        'rujukan',
    ];

    protected $casts = [
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
}
