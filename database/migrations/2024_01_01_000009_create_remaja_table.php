<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('remaja_identitas', function (Blueprint $table) {
            $table->id();

            // Foreign Key ke Kepala Keluarga
            $table->foreignId('kepala_keluarga_id')->constrained('kepala_keluarga')->onDelete('cascade');

            // IDENTITAS
            $table->string('nama_anak', 100);
            $table->string('nik', 50)->nullable();
            $table->date('tanggal_lahir');
            $table->string('jenis_kelamin', 20)->nullable(); // Laki-laki/Perempuan
            $table->string('nama_ortu', 100)->nullable();
            $table->string('no_hp', 20)->nullable();

            // RIWAYAT
            $table->text('riwayat_keluarga')->nullable();
            $table->text('riwayat_diri')->nullable();

            $table->timestamps();

            // Index untuk query optimization
            $table->index('kepala_keluarga_id');
            $table->index('tanggal_lahir');
            $table->index('nama_anak');
        });

        Schema::create('remaja_pemeriksaan', function (Blueprint $table) {
            $table->id();

            // Foreign Key ke Identitas Remaja
            $table->foreignId('remaja_identitas_id')->constrained('remaja_identitas')->onDelete('cascade');

            // KUNJUNGAN
            $table->string('waktu_kunjungan', 50)->nullable();

            // LANGKAH 1: PENGUKURAN ANTROPOMETRI
            $table->decimal('berat_badan', 5, 2)->nullable();
            $table->decimal('tinggi_badan', 5, 2)->nullable();

            // LANGKAH 2: PERHITUNGAN IMT
            $table->string('imt_status', 20)->nullable(); // Kurus/Normal/Gemuk/Obesitas
            $table->decimal('lingkar_perut', 5, 2)->nullable();

            // LANGKAH 3: PEMERIKSAAN TEKANAN DARAH & LABORATORIUM
            $table->integer('sistole')->nullable();
            $table->integer('diastole')->nullable();
            $table->string('tekanan_darah_status', 20)->nullable(); // Rendah/Normal/Tinggi

            $table->string('gula_darah', 20)->nullable();
            $table->string('hemoglobin', 20)->nullable();
            $table->string('anemia', 5)->nullable(); // Ya/Tidak

            // SKRINING TBC
            $table->string('batuk', 5)->nullable(); // Ya/Tidak
            $table->string('demam', 5)->nullable(); // Ya/Tidak
            $table->string('bb_turun', 5)->nullable(); // Ya/Tidak
            $table->string('kontak_tbc', 5)->nullable(); // Ya/Tidak

            // HEADSS ASSESSMENT (MENTAL & SOSIAL)
            $table->string('masalah_rumah', 5)->nullable(); // Ya/Tidak (Home)
            $table->string('masalah_pendidikan', 5)->nullable(); // Ya/Tidak (Education)
            $table->string('masalah_makan', 5)->nullable(); // Ya/Tidak (Eating)
            $table->string('masalah_aktivitas', 5)->nullable(); // Ya/Tidak (Activities)
            $table->string('masalah_obat', 5)->nullable(); // Ya/Tidak (Drugs/Substance)
            $table->string('masalah_seksual', 5)->nullable(); // Ya/Tidak (Sexual)
            $table->string('masalah_emosi', 5)->nullable(); // Ya/Tidak (Emotional/Mental Health)
            $table->string('masalah_keamanan', 5)->nullable(); // Ya/Tidak (Safety/Violence)

            // LANGKAH 5: EDUKASI & RUJUKAN
            $table->text('edukasi')->nullable();
            $table->string('rujukan', 100)->nullable();

            $table->timestamps();

            // Index untuk query optimization
            $table->index('remaja_identitas_id');
            $table->index('waktu_kunjungan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('remaja_pemeriksaan');
        Schema::dropIfExists('remaja_identitas');
    }
};
