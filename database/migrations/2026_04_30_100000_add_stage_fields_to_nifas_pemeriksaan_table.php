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
        if (!Schema::hasColumn('nifas_pemeriksaan', 'tahap_terakhir')) {
            Schema::table('nifas_pemeriksaan', function (Blueprint $table) {
                $table->integer('tahap_terakhir')->default(0)->after('nifas_identitas_id')->comment('Track examination progress (0-4)');
            });
        }
        
        if (!Schema::hasColumn('nifas_pemeriksaan', 'tanggal_kunjungan')) {
            Schema::table('nifas_pemeriksaan', function (Blueprint $table) {
                $table->date('tanggal_kunjungan')->nullable()->after('tahap_terakhir');
            });
        }

        if (!Schema::hasColumn('nifas_pemeriksaan', 'status_tbc')) {
            Schema::table('nifas_pemeriksaan', function (Blueprint $table) {
                $table->string('status_tbc', 50)->nullable()->after('kontak_tbc')->comment('TBC screening result');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nifas_pemeriksaan', function (Blueprint $table) {
            if (Schema::hasColumn('nifas_pemeriksaan', 'tahap_terakhir')) {
                $table->dropColumn('tahap_terakhir');
            }
            if (Schema::hasColumn('nifas_pemeriksaan', 'tanggal_kunjungan')) {
                $table->dropColumn('tanggal_kunjungan');
            }
            if (Schema::hasColumn('nifas_pemeriksaan', 'status_tbc')) {
                $table->dropColumn('status_tbc');
            }
        });
    }
};
