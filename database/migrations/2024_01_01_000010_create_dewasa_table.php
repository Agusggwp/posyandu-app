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
        Schema::create('dewasa_identitas', function (Blueprint $table) {
            $table->id();

            // Foreign Key ke Kepala Keluarga
            $table->foreignId('kepala_keluarga_id')->constrained('kepala_keluarga')->onDelete('cascade');

            // IDENTITAS
            $table->string('nama', 100);
            $table->string('nik', 50)->nullable();
            $table->date('tanggal_lahir');
            $table->string('umur', 50)->nullable();
            $table->text('alamat')->nullable();
            $table->string('no_hp', 20)->nullable();
            $table->string('status_perkawinan', 50)->nullable(); // Belum Kawin/Kawin/Cerai/Cerai Mati
            $table->string('pekerjaan', 100)->nullable();

            // LOKASI GEOGRAFIS
            $table->string('dusun', 100)->nullable();
            $table->string('desa', 100)->nullable();
            $table->string('kecamatan', 100)->nullable();

            // RIWAYAT
            $table->text('riwayat_keluarga')->nullable();
            $table->text('riwayat_diri')->nullable();

            // PERILAKU
            $table->string('merokok', 5)->nullable(); // Ya/Tidak
            $table->string('konsumsi_gula', 5)->nullable(); // Ya/Tidak
            $table->string('konsumsi_garam', 5)->nullable(); // Ya/Tidak
            $table->string('konsumsi_lemak', 5)->nullable(); // Ya/Tidak

            $table->timestamps();

            // Index untuk query optimization
            $table->index('kepala_keluarga_id');
            $table->index('tanggal_lahir');
            $table->index('nama');
            $table->index('nik');
        });

        Schema::create('dewasa_pemeriksaan', function (Blueprint $table) {
            $table->id();

            // Foreign Key ke Identitas Dewasa
            $table->foreignId('dewasa_identitas_id')->constrained('dewasa_identitas')->onDelete('cascade');

            // KUNJUNGAN
            $table->string('waktu_kunjungan', 50)->nullable();

            // LANGKAH 1: PENGUKURAN ANTROPOMETRI
            $table->decimal('berat_badan', 5, 2)->nullable();
            $table->decimal('tinggi_badan', 5, 2)->nullable();
            $table->string('imt', 20)->nullable(); // Kurus/Normal/Gemuk/Obesitas
            $table->decimal('lingkar_perut', 5, 2)->nullable();

            // LANGKAH 2: TEKANAN DARAH & GULA DARAH
            $table->integer('sistole')->nullable();
            $table->integer('diastole')->nullable();
            $table->string('tekanan_darah_status', 20)->nullable(); // Rendah/Normal/Tinggi
            $table->string('gula_darah', 20)->nullable();

            // TES LANJUT: FUNGSI SENSORIK
            $table->string('mata_kanan', 20)->nullable(); // Normal/Cacat/Kebutaan
            $table->string('mata_kiri', 20)->nullable(); // Normal/Cacat/Kebutaan
            $table->string('telinga_kanan', 20)->nullable(); // Normal/Cacat/Ketulian
            $table->string('telinga_kiri', 20)->nullable(); // Normal/Cacat/Ketulian

            // PUMA (PENYAKIT PARU - RISK SCORING)
            $table->string('jenis_kelamin', 20)->nullable(); // Laki-laki/Perempuan
            $table->string('usia_kategori', 20)->nullable(); // <40/40-49/50-59/60+
            $table->integer('skor_merokok')->nullable(); // 0-4 points
            $table->string('napas_berat', 5)->nullable(); // Ya/Tidak
            $table->string('dahak', 5)->nullable(); // Ya/Tidak
            $table->string('batuk', 5)->nullable(); // Ya/Tidak
            $table->string('aktivitas_terganggu', 5)->nullable(); // Ya/Tidak
            $table->string('pemeriksaan_sebelumnya', 5)->nullable(); // Ya/Tidak - dirawat untuk paru
            $table->integer('skor_puma')->nullable(); // Total score

            // SKRINING TBC
            $table->string('batuk_tbc', 5)->nullable(); // Ya/Tidak
            $table->string('demam', 5)->nullable(); // Ya/Tidak
            $table->string('bb_turun', 5)->nullable(); // Ya/Tidak
            $table->string('kontak_tbc', 5)->nullable(); // Ya/Tidak

            // LANGKAH 5: EDUKASI & RUJUKAN
            $table->text('edukasi')->nullable();
            $table->string('rujukan', 100)->nullable();

            $table->timestamps();

            // Index untuk query optimization
            $table->index('dewasa_identitas_id');
            $table->index('waktu_kunjungan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dewasa_pemeriksaan');
        Schema::dropIfExists('dewasa_identitas');
    }
};
