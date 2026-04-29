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
        Schema::table('ibu_hamil_pemeriksaan', function (Blueprint $table) {
            // Stage 1 - Penimbangan & Pengukuran
            $table->integer('usia_kehamilan')->nullable()->after('lingkar_lengan'); // minggu
            $table->enum('status_bb', ['Naik', 'Tidak'])->nullable()->after('usia_kehamilan');
            $table->enum('status_lila', ['Hijau', 'Kuning', 'Merah'])->nullable()->after('status_bb');

            // Stage 2 - Pemeriksaan
            $table->enum('status_tekanan_darah', ['Normal', 'Tinggi', 'Rendah'])->nullable()->after('denyut_jantung');
            $table->boolean('tb_skrining_batuk')->default(false)->after('status_tekanan_darah');
            $table->boolean('tb_skrining_demam')->default(false)->after('tb_skrining_batuk');
            $table->boolean('tb_skrining_bb_turun')->default(false)->after('tb_skrining_demam');
            $table->boolean('tb_skrining_kontak')->default(false)->after('tb_skrining_bb_turun');
            $table->enum('tb_skrining_hasil', ['Ya', 'Tidak', 'Dirujuk'])->nullable()->after('tb_skrining_kontak');

            // Stage 3 - Pelayanan Kesehatan
            $table->boolean('tablet_tambah_darah')->default(false)->after('tb_skrining_hasil');
            $table->boolean('pmt_bumil')->default(false)->after('tablet_tambah_darah');
            $table->boolean('kelas_ibu_hamil')->default(false)->after('pmt_bumil');

            // Stage 4 - Edukasi & Rujukan
            $table->text('edukasi')->nullable()->after('kelas_ibu_hamil');
            $table->enum('rujukan', ['Pustu', 'Puskesmas', 'Rumah Sakit', 'Tidak'])->default('Tidak')->after('edukasi');

            // Track completion stage
            $table->integer('tahap_terakhir')->default(0)->after('rujukan'); // 0=not started, 1-4=stages, 5=completed
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ibu_hamil_pemeriksaan', function (Blueprint $table) {
            $table->dropColumn([
                'usia_kehamilan',
                'status_bb',
                'status_lila',
                'status_tekanan_darah',
                'tb_skrining_batuk',
                'tb_skrining_demam',
                'tb_skrining_bb_turun',
                'tb_skrining_kontak',
                'tb_skrining_hasil',
                'tablet_tambah_darah',
                'pmt_bumil',
                'kelas_ibu_hamil',
                'edukasi',
                'rujukan',
                'tahap_terakhir'
            ]);
        });
    }
};
