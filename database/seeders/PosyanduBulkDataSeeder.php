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
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class PosyanduBulkDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        $jumlahKeluarga = 40;

        for ($i = 1; $i <= $jumlahKeluarga; $i++) {
            $email = "bulk.keluarga{$i}@example.com";
            $noKk = str_pad((string) (3301000000000000 + $i), 16, '0', STR_PAD_LEFT);
            $noNik = str_pad((string) (3302000000000000 + $i), 16, '0', STR_PAD_LEFT);

            $keluarga = Keluarga::updateOrCreate(
                ['email' => $email],
                [
                    'no_kk' => $noKk,
                    'nama_lengkap' => $faker->name(),
                    'password' => Hash::make('password'),
                    'no_nik' => $noNik,
                    'alamat' => $faker->streetAddress() . ', ' . $faker->city(),
                    'no_telepon' => '08' . $faker->numerify('##########'),
                    'email_verified_at' => now(),
                    'status' => 'approved',
                ]
            );

            $this->seedBalita($faker, $keluarga, $i);
            $this->seedIbuHamil($faker, $keluarga, $i);
            $this->seedNifas($faker, $keluarga, $i);
            $this->seedRemaja($faker, $keluarga, $i);
            $this->seedLansia($faker, $keluarga, $i);
        }
    }

    private function seedBalita($faker, Keluarga $keluarga, int $i): void
    {
        $jumlah = rand(1, 2);

        for ($j = 1; $j <= $jumlah; $j++) {
            $nama = "Balita {$i}-{$j}";
            $tanggalLahir = Carbon::now()->subMonths(rand(8, 55))->subDays(rand(0, 20));

            $balita = Balita::updateOrCreate(
                ['kepala_keluarga_id' => $keluarga->id, 'nama_bayi' => $nama],
                [
                    'nik' => str_pad((string) (3311000000000000 + ($i * 10) + $j), 16, '0', STR_PAD_LEFT),
                    'jenis_kelamin' => rand(0, 1) ? 'L' : 'P',
                    'tanggal_lahir' => $tanggalLahir->toDateString(),
                    'berat_badan_lahir' => rand(24, 38) / 10,
                    'panjang_badan_lahir' => rand(45, 54),
                    'nama_ortu' => $keluarga->nama_lengkap,
                    'no_hp' => '08' . $faker->numerify('##########'),
                ]
            );

            for ($k = 0; $k < 5; $k++) {
                $tanggal = Carbon::now()->subMonths(4 - $k)->setTime(8, rand(0, 59));

                PemeriksaanBalita::updateOrCreate(
                    [
                        'balita_identitas_id' => $balita->id,
                        'waktu_kunjungan' => $tanggal->format('Y-m-d H:i:s'),
                    ],
                    [
                        'umur' => (int) $tanggalLahir->diffInMonths($tanggal),
                        'berat_badan' => 8.5 + ($k * 0.4) + rand(0, 4) / 10,
                        'naik_tidak_naik' => 'Naik',
                        'status_bb_u' => 'N',
                        'panjang_badan' => 75 + ($k * 1.2) + rand(0, 8) / 10,
                        'status_pb_u' => 'P',
                        'status_bb_pb' => 'B',
                        'lingkar_lengan' => 14 + ($k * 0.15),
                        'status_lila' => 'H',
                        'lingkar_kepala' => 46 + ($k * 0.2),
                        'perkembangan' => 'Lengkap',
                        'asi_eksklusif' => true,
                        'mpasi' => true,
                        'vitamin_a' => rand(0, 1),
                        'obat_cacing' => rand(0, 1),
                        'catatan_kesehatan' => 'Kontrol rutin bulanan',
                    ]
                );
            }
        }
    }

    private function seedIbuHamil($faker, Keluarga $keluarga, int $i): void
    {
        $jumlah = rand(0, 1);

        for ($j = 1; $j <= $jumlah; $j++) {
            $nama = "Ibu Hamil {$i}-{$j}";
            $tanggalLahir = Carbon::now()->subYears(rand(20, 38))->subDays(rand(0, 200));

            $ibu = IbuHamil::updateOrCreate(
                ['kepala_keluarga_id' => $keluarga->id, 'nama_ibu' => $nama],
                [
                    'nik' => str_pad((string) (3321000000000000 + ($i * 10) + $j), 16, '0', STR_PAD_LEFT),
                    'tanggal_lahir' => $tanggalLahir->toDateString(),
                    'umur' => (string) $tanggalLahir->age,
                    'nama_suami' => $faker->name('male'),
                    'no_hp' => '08' . $faker->numerify('##########'),
                    'l_ibu_hamil' => rand(22, 30) . ' cm',
                    'kehamilan_ke' => rand(1, 4),
                    'jarak_anak_sebelumnya' => rand(1, 6) . ' tahun',
                ]
            );

            for ($k = 0; $k < 4; $k++) {
                $tanggal = Carbon::now()->subMonths(3 - $k)->toDateString();

                PemeriksaanIbuHamil::updateOrCreate(
                    [
                        'ibu_hamil_identitas_id' => $ibu->id,
                        'tanggal_kunjungan' => $tanggal,
                    ],
                    [
                        'tinggi_badan' => rand(148, 168),
                        'berat_badan' => 50 + ($k * 0.8) + rand(0, 5) / 10,
                        'lingkar_lengan' => 23 + ($k * 0.1),
                        'tekanan_darah' => rand(110, 130) . '/' . rand(70, 85),
                        'denyut_jantung' => (string) rand(78, 90),
                        'kondisi_ibu' => 'Baik',
                        'keluhan' => $k === 0 ? 'Mual ringan' : 'Tidak ada',
                        'waktu_ke_posyandu' => 'Pagi',
                        'petugas' => 'Bidan ' . $faker->firstNameFemale,
                        'catatan' => 'Kontrol kehamilan rutin',
                    ]
                );
            }
        }
    }

    private function seedNifas($faker, Keluarga $keluarga, int $i): void
    {
        $jumlah = rand(0, 1);

        for ($j = 1; $j <= $jumlah; $j++) {
            $nama = "Nifas {$i}-{$j}";
            $tanggalLahir = Carbon::now()->subYears(rand(20, 38))->subDays(rand(0, 200));

            $nifas = Nifas::updateOrCreate(
                ['kepala_keluarga_id' => $keluarga->id, 'nama_ibu' => $nama],
                [
                    'nik' => str_pad((string) (3331000000000000 + ($i * 10) + $j), 16, '0', STR_PAD_LEFT),
                    'tanggal_lahir' => $tanggalLahir->toDateString(),
                    'umur' => (string) $tanggalLahir->age,
                    'nama_suami' => $faker->name('male'),
                    'no_hp' => '08' . $faker->numerify('##########'),
                    'tanggal_bersalin' => Carbon::now()->subDays(rand(10, 40))->toDateString(),
                    'tempat_bersalin' => 'Puskesmas ' . $faker->city(),
                    'anak_ke' => rand(1, 4),
                    'tinggi_badan_ibu' => rand(148, 166),
                ]
            );

            for ($k = 0; $k < 3; $k++) {
                $tanggal = Carbon::now()->subDays(20 - ($k * 7))->setTime(9, rand(0, 59));

                PemeriksaanNifas::updateOrCreate(
                    [
                        'nifas_identitas_id' => $nifas->id,
                        'waktu_kunjungan' => $tanggal->format('Y-m-d H:i:s'),
                    ],
                    [
                        'berat_badan' => 60 - ($k * 0.4) + rand(0, 3) / 10,
                        'naik_turun' => 'Turun',
                        'tinggi_badan' => (float) $nifas->tinggi_badan_ibu,
                        'lila' => 24 + rand(0, 3) / 10,
                        'status_gizi' => 'H',
                        'sistole' => rand(110, 126),
                        'diastole' => rand(70, 84),
                        'tekanan_darah_status' => 'N',
                        'vitamin_a' => 'Ya',
                        'menyusui' => 'Ya',
                        'kb' => 'Suntik',
                        'edukasi' => 'Lanjutkan pola makan sehat',
                    ]
                );
            }
        }
    }

    private function seedRemaja($faker, Keluarga $keluarga, int $i): void
    {
        $jumlah = rand(0, 2);

        for ($j = 1; $j <= $jumlah; $j++) {
            $nama = "Remaja {$i}-{$j}";
            $tanggalLahir = Carbon::now()->subYears(rand(12, 18))->subDays(rand(0, 300));

            $remaja = Remaja::updateOrCreate(
                ['kepala_keluarga_id' => $keluarga->id, 'nama_anak' => $nama],
                [
                    'nik' => str_pad((string) (3341000000000000 + ($i * 10) + $j), 16, '0', STR_PAD_LEFT),
                    'tanggal_lahir' => $tanggalLahir->toDateString(),
                    'jenis_kelamin' => rand(0, 1) ? 'L' : 'P',
                    'nama_ortu' => $keluarga->nama_lengkap,
                    'no_hp' => '08' . $faker->numerify('##########'),
                    'riwayat_keluarga' => 'Hipertensi ringan pada keluarga',
                    'riwayat_diri' => 'Tidak ada keluhan berat',
                ]
            );

            for ($k = 0; $k < 4; $k++) {
                $tanggal = Carbon::now()->subMonths(3 - $k)->setTime(10, rand(0, 59));

                PemeriksaanRemaja::updateOrCreate(
                    [
                        'remaja_identitas_id' => $remaja->id,
                        'waktu_kunjungan' => $tanggal->format('Y-m-d H:i:s'),
                    ],
                    [
                        'berat_badan' => 42 + ($k * 0.6) + rand(0, 6) / 10,
                        'tinggi_badan' => 150 + ($k * 0.9) + rand(0, 6) / 10,
                        'imt_status' => 'Normal',
                        'lingkar_perut' => 67 + ($k * 0.5),
                        'sistole' => rand(105, 120),
                        'diastole' => rand(65, 80),
                        'tekanan_darah_status' => 'Normal',
                        'anemia' => 'Tidak',
                        'edukasi' => 'Tetap aktif olahraga',
                        'rujukan' => 'Tidak ada',
                    ]
                );
            }
        }
    }

    private function seedLansia($faker, Keluarga $keluarga, int $i): void
    {
        $jumlah = rand(0, 2);

        for ($j = 1; $j <= $jumlah; $j++) {
            $nama = "Lansia {$i}-{$j}";
            $tanggalLahir = Carbon::now()->subYears(rand(60, 85))->subDays(rand(0, 300));

            $lansia = Lansia::updateOrCreate(
                ['kepala_keluarga_id' => $keluarga->id, 'nama' => $nama],
                [
                    'nik' => str_pad((string) (3351000000000000 + ($i * 10) + $j), 16, '0', STR_PAD_LEFT),
                    'tanggal_lahir' => $tanggalLahir->toDateString(),
                    'umur' => (string) $tanggalLahir->age,
                    'no_hp' => '08' . $faker->numerify('##########'),
                    'status_perkawinan' => rand(0, 1) ? 'Kawin' : 'Cerai Mati',
                    'pekerjaan' => 'Pensiunan',
                    'riwayat_keluarga' => 'Riwayat hipertensi',
                    'riwayat_diri' => 'Hipertensi terkontrol',
                    'merokok' => rand(0, 1) ? 'Ya' : 'Tidak',
                    'konsumsi_gula' => 'Ya',
                    'konsumsi_garam' => 'Ya',
                    'konsumsi_lemak' => rand(0, 1) ? 'Ya' : 'Tidak',
                ]
            );

            for ($k = 0; $k < 5; $k++) {
                $tanggal = Carbon::now()->subMonths(4 - $k)->setTime(11, rand(0, 59));

                PemeriksaanLansia::updateOrCreate(
                    [
                        'dewasa_identitas_id' => $lansia->id,
                        'waktu_kunjungan' => $tanggal->format('Y-m-d H:i:s'),
                    ],
                    [
                        'berat_badan' => 58 + rand(0, 25) / 10,
                        'tinggi_badan' => rand(145, 166),
                        'imt' => 'Normal',
                        'lingkar_perut' => 80 + rand(0, 50) / 10,
                        'sistole' => rand(118, 150),
                        'diastole' => rand(72, 95),
                        'tekanan_darah_status' => rand(0, 1) ? 'Normal' : 'Tinggi',
                        'gula_darah' => (string) rand(110, 180),
                        'edukasi' => 'Kontrol pola makan dan aktivitas',
                        'rujukan' => rand(0, 3) === 0 ? 'Puskesmas' : 'Tidak ada',
                    ]
                );
            }
        }
    }
}
