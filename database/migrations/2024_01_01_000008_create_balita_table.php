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
        Schema::create('balita_identitas', function (Blueprint $table) {
            $table->id();

            // Foreign Key ke Kepala Keluarga
            $table->foreignId('kepala_keluarga_id')->constrained('kepala_keluarga')->onDelete('cascade');

            // IDENTITAS BAYI
            $table->string('nama_bayi', 100);
            $table->string('nik', 50)->nullable();
            $table->string('jenis_kelamin', 20)->nullable(); // Laki-laki/Perempuan
            $table->date('tanggal_lahir');
            $table->decimal('berat_badan_lahir', 5, 2)->nullable();
            $table->decimal('panjang_badan_lahir', 5, 2)->nullable();

            // DATA ORANG TUA
            $table->string('nama_ortu', 100)->nullable();
            $table->text('alamat')->nullable();
            $table->string('no_hp', 20)->nullable();

            // LOKASI GEOGRAFIS
            $table->string('dusun', 100)->nullable();
            $table->string('desa', 100)->nullable();
            $table->string('kecamatan', 100)->nullable();

            $table->timestamps();

            // Index untuk query optimization
            $table->index('kepala_keluarga_id');
            $table->index('tanggal_lahir');
            $table->index('nama_bayi');
        });

        Schema::create('balita_pemeriksaan', function (Blueprint $table) {
            $table->id();

            // Foreign Key ke Identitas Balita
            $table->foreignId('balita_identitas_id')->constrained('balita_identitas')->onDelete('cascade');

            // KUNJUNGAN
            $table->integer('umur')->nullable(); // dalam bulan
            $table->string('waktu_kunjungan', 50)->nullable();

            // LANGKAH 1: PENIMBANGAN
            $table->decimal('berat_badan', 5, 2)->nullable();
            $table->string('naik_tidak_naik', 10)->nullable(); // Naik/Tidak Naik

            // LANGKAH 2: STATUS GIZI (BB/U, PB/U, BB/PB)
            $table->string('status_bb_u', 20)->nullable(); // SK/N/T (Sangat Kurang/Normal/Tinggi)
            $table->decimal('panjang_badan', 5, 2)->nullable();
            $table->string('status_pb_u', 20)->nullable(); // SP/P (Sangat Pendek/Pendek)
            $table->string('status_bb_pb', 20)->nullable(); // B/K/L (Baik/Kurang/Lebih)

            // LANGKAH 3: LILA & LINGKAR KEPALA
            $table->decimal('lingkar_lengan', 5, 2)->nullable();
            $table->string('status_lila', 10)->nullable(); // H/K/M (Healthy/Kurang/Malnutrisi)
            $table->decimal('lingkar_kepala', 5, 2)->nullable();

            // SKRINING TBC
            $table->string('batuk', 5)->nullable(); // Ya/Tidak
            $table->string('demam', 5)->nullable(); // Ya/Tidak
            $table->string('bb_turun', 5)->nullable(); // Ya/Tidak
            $table->string('kontak_tbc', 5)->nullable(); // Ya/Tidak

            // LANGKAH 4: PROMOSI KESEHATAN & NUTRISI
            $table->string('perkembangan', 20)->nullable(); // Lengkap/Tidak/Monitor
            $table->string('asi_eksklusif', 5)->nullable(); // Ya/Tidak
            $table->string('mpasi', 5)->nullable(); // Ya/Tidak (Makanan Pendamping ASI)
            $table->text('imunisasi')->nullable();
            $table->string('vitamin_a', 5)->nullable(); // Ya/Tidak
            $table->string('obat_cacing', 5)->nullable(); // Ya/Tidak
            $table->string('mt_pangan', 5)->nullable(); // Ya/Tidak (Modifikasi Teknis Pangan)

            // LANGKAH 5: EDUKASI & RUJUKAN
            $table->text('edukasi')->nullable();
            $table->text('catatan_kesehatan')->nullable();
            $table->string('rujukan', 100)->nullable();

            $table->timestamps();

            // Index untuk query optimization
            $table->index('balita_identitas_id');
            $table->index('waktu_kunjungan');
            $table->index('umur');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('balita_pemeriksaan');
        Schema::dropIfExists('balita_identitas');
    }
};
