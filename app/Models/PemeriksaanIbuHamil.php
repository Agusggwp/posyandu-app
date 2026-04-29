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
        'usia_kehamilan',
        'status_bb',
        'status_lila',
        'tekanan_darah',
        'denyut_jantung',
        'status_tekanan_darah',
        'tb_skrining_batuk',
        'tb_skrining_demam',
        'tb_skrining_bb_turun',
        'tb_skrining_kontak',
        'tb_skrining_hasil',
        'kondisi_ibu',
        'keluhan',
        'tablet_tambah_darah',
        'pmt_bumil',
        'kelas_ibu_hamil',
        'edukasi',
        'rujukan',
        'tanggal_kunjungan',
        'waktu_ke_posyandu',
        'petugas',
        'catatan',
        'tahap_terakhir'
    ];

    protected $casts = [
        'tanggal_kunjungan' => 'date',
    ];

    public function ibuHamil()
    {
        return $this->belongsTo(IbuHamil::class, 'ibu_hamil_identitas_id');
    }
}
