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
            if (!Schema::hasColumn('dewasa_pemeriksaan', 'status_berat_badan')) {
                $table->string('status_berat_badan')->nullable()->after('imt');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dewasa_pemeriksaan', function (Blueprint $table) {
            if (Schema::hasColumn('dewasa_pemeriksaan', 'status_berat_badan')) {
                $table->dropColumn('status_berat_badan');
            }
        });
    }
};
