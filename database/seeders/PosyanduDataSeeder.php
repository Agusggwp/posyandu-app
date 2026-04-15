<?php

namespace Database\Seeders;

use App\Models\Balita;
use App\Models\IbuHamil;
use App\Models\Keluarga;
use App\Models\Lansia;
use App\Models\Nifas;
use App\Models\PemeriksaanBalita;
use App\Models\PemeriksaanIbuHamil;
use App\Models\PemeriksaanLansia;
use App\Models\PemeriksaanNifas;
use App\Models\PemeriksaanRemaja;
use App\Models\Remaja;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PosyanduDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $keluargaA = Keluarga::updateOrCreate(
            ['email' => 'keluarga.rahman@example.com'],
            [
                'no_kk' => '3174010101010001',
                'nama_lengkap' => 'Rahman Hidayat',
                'password' => Hash::make('password'),
                'no_nik' => '3174010101010001',
                'alamat' => 'Jl. Melati No. 12, Cibinong',
                'no_telepon' => '081234560001',
                'email_verified_at' => now(),
                'status' => 'approved',
            ]
        );

        $keluargaB = Keluarga::updateOrCreate(
            ['email' => 'keluarga.sari@example.com'],
            [
                'no_kk' => '3174010101010002',
                'nama_lengkap' => 'Sari Andayani',
                'password' => Hash::make('password'),
                'no_nik' => '3174010101010002',
                'alamat' => 'Jl. Kenanga No. 21, Cibinong',
                'no_telepon' => '081234560002',
                'email_verified_at' => now(),
                'status' => 'approved',
            ]
        );

        $balita = Balita::updateOrCreate(
            ['kepala_keluarga_id' => $keluargaA->id, 'nama_bayi' => 'Alya Putri'],
            [
                'nik' => '3174010101010101',
                'jenis_kelamin' => 'P',
                'tanggal_lahir' => '2022-07-10',
                'berat_badan_lahir' => 3.10,
                'panjang_badan_lahir' => 49.5,
                'nama_ortu' => 'Rahman Hidayat',
                'no_hp' => '081234560011',
            ]
        );

        $ibuHamil = IbuHamil::updateOrCreate(
            ['kepala_keluarga_id' => $keluargaB->id, 'nama_ibu' => 'Sari Andayani'],
            [
                'nik' => '3174010101010201',
                'tanggal_lahir' => '1994-03-11',
                'umur' => '32',
                'nama_suami' => 'Dedi Santoso',
                'no_hp' => '081234560021',
                'l_ibu_hamil' => '23 cm',
                'kehamilan_ke' => 2,
                'jarak_anak_sebelumnya' => '4 tahun',
            ]
        );

        $nifas = Nifas::updateOrCreate(
            ['kepala_keluarga_id' => $keluargaB->id, 'nama_ibu' => 'Lina Marlina'],
            [
                'nik' => '3174010101010301',
                'tanggal_lahir' => '1996-08-05',
                'umur' => '29',
                'nama_suami' => 'Rudi Hermawan',
                'no_hp' => '081234560031',
                'tanggal_bersalin' => '2026-03-22',
                'tempat_bersalin' => 'Puskesmas Cibinong',
                'anak_ke' => 1,
                'tinggi_badan_ibu' => 158.2,
            ]
        );

        $remaja = Remaja::updateOrCreate(
            ['kepala_keluarga_id' => $keluargaA->id, 'nama_anak' => 'Raka Pratama'],
            [
                'nik' => '3174010101010401',
                'tanggal_lahir' => '2010-10-20',
                'jenis_kelamin' => 'L',
                'nama_ortu' => 'Rahman Hidayat',
                'no_hp' => '081234560041',
                'riwayat_keluarga' => 'Hipertensi pada kakek',
                'riwayat_diri' => 'Tidak ada penyakit kronis',
            ]
        );

        $lansia = Lansia::updateOrCreate(
            ['kepala_keluarga_id' => $keluargaA->id, 'nama' => 'Aminah'],
            [
                'nik' => '3174010101010501',
                'tanggal_lahir' => '1958-01-02',
                'umur' => '68',
                'no_hp' => '081234560051',
                'status_perkawinan' => 'Kawin',
                'pekerjaan' => 'Ibu Rumah Tangga',
                'riwayat_keluarga' => 'Diabetes pada saudara kandung',
                'riwayat_diri' => 'Hipertensi ringan',
                'merokok' => 'Tidak',
                'konsumsi_gula' => 'Ya',
                'konsumsi_garam' => 'Ya',
                'konsumsi_lemak' => 'Tidak',
            ]
        );

        PemeriksaanBalita::updateOrCreate(
            ['balita_identitas_id' => $balita->id, 'waktu_kunjungan' => '2026-02-01 08:30:00'],
            [
                'umur' => 43,
                'berat_badan' => 13.4,
                'naik_tidak_naik' => 'Naik',
                'status_bb_u' => 'N',
                'panjang_badan' => 91.2,
                'status_pb_u' => 'P',
                'status_bb_pb' => 'B',
                'lingkar_lengan' => 15.1,
                'status_lila' => 'H',
                'lingkar_kepala' => 48.0,
                'perkembangan' => 'Lengkap',
                'asi_eksklusif' => true,
                'mpasi' => true,
                'vitamin_a' => true,
                'obat_cacing' => false,
                'catatan_kesehatan' => 'Perkembangan baik',
            ]
        );

        PemeriksaanBalita::updateOrCreate(
            ['balita_identitas_id' => $balita->id, 'waktu_kunjungan' => '2026-03-01 08:35:00'],
            [
                'umur' => 44,
                'berat_badan' => 13.9,
                'naik_tidak_naik' => 'Naik',
                'status_bb_u' => 'N',
                'panjang_badan' => 92.0,
                'status_pb_u' => 'P',
                'status_bb_pb' => 'B',
                'lingkar_lengan' => 15.4,
                'status_lila' => 'H',
                'lingkar_kepala' => 48.4,
                'perkembangan' => 'Lengkap',
                'asi_eksklusif' => true,
                'mpasi' => true,
                'vitamin_a' => true,
                'obat_cacing' => true,
                'catatan_kesehatan' => 'Berat badan meningkat',
            ]
        );

        PemeriksaanIbuHamil::updateOrCreate(
            ['ibu_hamil_identitas_id' => $ibuHamil->id, 'tanggal_kunjungan' => '2026-02-10'],
            [
                'tinggi_badan' => 160.0,
                'berat_badan' => 56.2,
                'lingkar_lengan' => 24.1,
                'tekanan_darah' => '120/80',
                'denyut_jantung' => '80',
                'kondisi_ibu' => 'Baik',
                'keluhan' => 'Mual ringan',
                'waktu_ke_posyandu' => 'Pagi',
                'petugas' => 'Bidan Rina',
                'catatan' => 'Kontrol rutin trimester 2',
            ]
        );

        PemeriksaanIbuHamil::updateOrCreate(
            ['ibu_hamil_identitas_id' => $ibuHamil->id, 'tanggal_kunjungan' => '2026-03-10'],
            [
                'tinggi_badan' => 160.0,
                'berat_badan' => 57.0,
                'lingkar_lengan' => 24.5,
                'tekanan_darah' => '118/78',
                'denyut_jantung' => '82',
                'kondisi_ibu' => 'Baik',
                'keluhan' => 'Tidak ada',
                'waktu_ke_posyandu' => 'Pagi',
                'petugas' => 'Bidan Rina',
                'catatan' => 'Perkembangan janin baik',
            ]
        );

        PemeriksaanNifas::updateOrCreate(
            ['nifas_identitas_id' => $nifas->id, 'waktu_kunjungan' => '2026-03-25 09:00:00'],
            [
                'berat_badan' => 59.2,
                'naik_turun' => 'Turun',
                'tinggi_badan' => 158.2,
                'lila' => 24.0,
                'status_gizi' => 'H',
                'sistole' => 120,
                'diastole' => 82,
                'tekanan_darah_status' => 'N',
                'vitamin_a' => 'Ya',
                'menyusui' => 'Ya',
                'kb' => 'Suntik',
                'edukasi' => 'Lanjutkan ASI eksklusif',
            ]
        );

        PemeriksaanNifas::updateOrCreate(
            ['nifas_identitas_id' => $nifas->id, 'waktu_kunjungan' => '2026-04-08 09:10:00'],
            [
                'berat_badan' => 58.4,
                'naik_turun' => 'Turun',
                'tinggi_badan' => 158.2,
                'lila' => 24.3,
                'status_gizi' => 'H',
                'sistole' => 118,
                'diastole' => 80,
                'tekanan_darah_status' => 'N',
                'vitamin_a' => 'Ya',
                'menyusui' => 'Ya',
                'kb' => 'Suntik',
                'edukasi' => 'Kondisi ibu stabil',
            ]
        );

        PemeriksaanRemaja::updateOrCreate(
            ['remaja_identitas_id' => $remaja->id, 'waktu_kunjungan' => '2026-02-12 10:00:00'],
            [
                'berat_badan' => 52.0,
                'tinggi_badan' => 160.0,
                'imt_status' => 'Normal',
                'lingkar_perut' => 70.2,
                'sistole' => 110,
                'diastole' => 70,
                'tekanan_darah_status' => 'Normal',
                'anemia' => 'Tidak',
                'edukasi' => 'Aktivitas fisik rutin',
                'rujukan' => 'Tidak ada',
            ]
        );

        PemeriksaanRemaja::updateOrCreate(
            ['remaja_identitas_id' => $remaja->id, 'waktu_kunjungan' => '2026-03-12 10:05:00'],
            [
                'berat_badan' => 53.1,
                'tinggi_badan' => 160.8,
                'imt_status' => 'Normal',
                'lingkar_perut' => 71.0,
                'sistole' => 112,
                'diastole' => 72,
                'tekanan_darah_status' => 'Normal',
                'anemia' => 'Tidak',
                'edukasi' => 'Lanjutkan pola makan sehat',
                'rujukan' => 'Tidak ada',
            ]
        );

        PemeriksaanLansia::updateOrCreate(
            ['dewasa_identitas_id' => $lansia->id, 'waktu_kunjungan' => '2026-02-20 11:00:00'],
            [
                'berat_badan' => 61.5,
                'tinggi_badan' => 154.0,
                'imt' => 'Normal',
                'lingkar_perut' => 83.0,
                'sistole' => 142,
                'diastole' => 90,
                'tekanan_darah_status' => 'Tinggi',
                'gula_darah' => '145',
                'edukasi' => 'Kurangi gula dan garam',
                'rujukan' => 'Puskesmas',
            ]
        );

        PemeriksaanLansia::updateOrCreate(
            ['dewasa_identitas_id' => $lansia->id, 'waktu_kunjungan' => '2026-03-20 11:15:00'],
            [
                'berat_badan' => 60.9,
                'tinggi_badan' => 154.0,
                'imt' => 'Normal',
                'lingkar_perut' => 82.2,
                'sistole' => 136,
                'diastole' => 86,
                'tekanan_darah_status' => 'Normal',
                'gula_darah' => '132',
                'edukasi' => 'Kondisi membaik, lanjut diet',
                'rujukan' => 'Tidak ada',
            ]
        );
    }
}
