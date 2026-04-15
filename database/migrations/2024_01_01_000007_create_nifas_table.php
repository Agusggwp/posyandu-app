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
        Schema::create('nifas_identitas', function (Blueprint $table) {
            $table->id();

            // Foreign Key ke Kepala Keluarga
            $table->foreignId('kepala_keluarga_id')->constrained('kepala_keluarga')->onDelete('cascade');

            // IDENTITAS
            $table->string('nama_ibu', 100);
            $table->string('nik', 50)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('umur', 50)->nullable();
            $table->string('nama_suami', 100)->nullable();
            $table->string('no_hp', 20)->nullable();

            // DATA NIFAS (POSTPARTUM)
            $table->date('tanggal_bersalin')->nullable();
            $table->string('tempat_bersalin', 100)->nullable();
            $table->integer('anak_ke')->nullable();
            $table->decimal('tinggi_badan_ibu', 5, 2)->nullable();

            $table->timestamps();

            // Index untuk query optimization
            $table->index('kepala_keluarga_id');
            $table->index('tanggal_bersalin');
            $table->index('nama_ibu');
        });

        Schema::create('nifas_pemeriksaan', function (Blueprint $table) {
            $table->id();

            // Foreign Key ke Identitas Nifas
            $table->foreignId('nifas_identitas_id')->constrained('nifas_identitas')->onDelete('cascade');

            // KUNJUNGAN (PER BARIS = 1 PEMERIKSAAN)
            $table->string('waktu_kunjungan', 50)->nullable();

            // LANGKAH 1: PENIMBANGAN
            $table->decimal('berat_badan', 5, 2)->nullable();
            $table->string('naik_turun', 10)->nullable(); // Naik/Turun

            // LANGKAH 2: PENGUKURAN TINGGI & LILA
            $table->decimal('tinggi_badan', 5, 2)->nullable();
            $table->decimal('lila', 5, 2)->nullable(); // Lingkar Lengan Atas (LILA)
            $table->string('status_gizi', 10)->nullable(); // H (Healthy)/K (Kurang)/M (Malnutrition)

            // LANGKAH 3: PEMERIKSAAN TEKANAN DARAH
            $table->integer('sistole')->nullable();
            $table->integer('diastole')->nullable();
            $table->string('tekanan_darah_status', 20)->nullable(); // R (Rendah)/N (Normal)/T (Tinggi)

            // SKRINING TBC
            $table->string('batuk', 5)->nullable(); // Ya/Tidak
            $table->string('demam', 5)->nullable(); // Ya/Tidak
            $table->string('bb_turun', 5)->nullable(); // Ya/Tidak (Berat Badan Turun)
            $table->string('kontak_tbc', 5)->nullable(); // Ya/Tidak (Kontak dengan TBC)

            // LANGKAH 4 & 5: EDUKASI & INTERVENSI
            $table->string('vitamin_a', 5)->nullable(); // Ya/Tidak
            $table->string('menyusui', 5)->nullable(); // Ya/Tidak
            $table->string('kb', 50)->nullable(); // Jenis KB
            $table->text('edukasi')->nullable();
            $table->string('rujukan', 100)->nullable();

            $table->timestamps();

            // Index untuk query optimization
            $table->index('nifas_identitas_id');
            $table->index('waktu_kunjungan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nifas_pemeriksaan');
        Schema::dropIfExists('nifas_identitas');
    }
};
