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
        Schema::table('balita_pemeriksaan', function (Blueprint $table) {
            // Add tahap_terakhir if it doesn't exist
            if (!Schema::hasColumn('balita_pemeriksaan', 'tahap_terakhir')) {
                $table->integer('tahap_terakhir')->default(0)->after('balita_identitas_id');
            }

            // Add tanggal_kunjungan if it doesn't exist
            if (!Schema::hasColumn('balita_pemeriksaan', 'tanggal_kunjungan')) {
                $table->date('tanggal_kunjungan')->nullable()->after('tahap_terakhir');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('balita_pemeriksaan', function (Blueprint $table) {
            if (Schema::hasColumn('balita_pemeriksaan', 'tahap_terakhir')) {
                $table->dropColumn('tahap_terakhir');
            }
            if (Schema::hasColumn('balita_pemeriksaan', 'tanggal_kunjungan')) {
                $table->dropColumn('tanggal_kunjungan');
            }
        });
    }
};
