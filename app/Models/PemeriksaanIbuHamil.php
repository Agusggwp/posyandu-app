<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PemeriksaanIbuHamil extends Model
{
    protected $table = 'ibu_hamil_pemeriksaan';

    protected $fillable = [
        'ibu_hamil_identitas_id',
        'tinggi_badan',
        'berat_badan',
        'lingkar_lengan',
        'tekanan_darah',
        'denyut_jantung',
        'kondisi_ibu',
        'keluhan',
        'tanggal_kunjungan',
        'waktu_ke_posyandu',
        'petugas',
        'catatan'
    ];

    protected $casts = [
        'tanggal_kunjungan' => 'date',
    ];

    public function ibuHamil()
    {
        return $this->belongsTo(IbuHamil::class, 'ibu_hamil_identitas_id');
    }
}
