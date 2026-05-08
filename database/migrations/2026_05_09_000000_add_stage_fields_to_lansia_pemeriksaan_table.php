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
        Schema::table('dewasa_pemeriksaan', function (Blueprint $table) {
            // Add tahap_terakhir if it doesn't exist
            if (!Schema::hasColumn('dewasa_pemeriksaan', 'tahap_terakhir')) {
                $table->integer('tahap_terakhir')->default(0)->after('dewasa_identitas_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dewasa_pemeriksaan', function (Blueprint $table) {
            if (Schema::hasColumn('dewasa_pemeriksaan', 'tahap_terakhir')) {
                $table->dropColumn('tahap_terakhir');
            }
        });
    }
};
