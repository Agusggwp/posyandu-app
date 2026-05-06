<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('remaja_pemeriksaan', function (Blueprint $table) {
            if (!Schema::hasColumn('remaja_pemeriksaan', 'tahap_terakhir')) {
                $table->integer('tahap_terakhir')->default(0)->after('waktu_kunjungan')->comment('Track examination progress (0-4)');
            }
        });
    }

    public function down(): void
    {
        Schema::table('remaja_pemeriksaan', function (Blueprint $table) {
            if (Schema::hasColumn('remaja_pemeriksaan', 'tahap_terakhir')) {
                $table->dropColumn('tahap_terakhir');
            }
        });
    }
};
