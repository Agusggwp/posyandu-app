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
        // Add tanggal_kunjungan to dewasa_pemeriksaan
        Schema::table('dewasa_pemeriksaan', function (Blueprint $table) {
            if (!Schema::hasColumn('dewasa_pemeriksaan', 'tanggal_kunjungan')) {
                $table->date('tanggal_kunjungan')->nullable()->after('waktu_kunjungan');
                $table->index('tanggal_kunjungan');
            }
        });

        // Add tanggal_kunjungan to remaja_pemeriksaan
        Schema::table('remaja_pemeriksaan', function (Blueprint $table) {
            if (!Schema::hasColumn('remaja_pemeriksaan', 'tanggal_kunjungan')) {
                $table->date('tanggal_kunjungan')->nullable()->after('waktu_kunjungan');
                $table->index('tanggal_kunjungan');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dewasa_pemeriksaan', function (Blueprint $table) {
            if (Schema::hasColumn('dewasa_pemeriksaan', 'tanggal_kunjungan')) {
                $table->dropIndex(['tanggal_kunjungan']);
                $table->dropColumn('tanggal_kunjungan');
            }
        });

        Schema::table('remaja_pemeriksaan', function (Blueprint $table) {
            if (Schema::hasColumn('remaja_pemeriksaan', 'tanggal_kunjungan')) {
                $table->dropIndex(['tanggal_kunjungan']);
                $table->dropColumn('tanggal_kunjungan');
            }
        });
    }
};
