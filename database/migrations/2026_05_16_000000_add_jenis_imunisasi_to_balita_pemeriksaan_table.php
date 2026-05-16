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
            if (!Schema::hasColumn('balita_pemeriksaan', 'jenis_imunisasi')) {
                $table->text('jenis_imunisasi')->nullable()->after('imunisasi');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('balita_pemeriksaan', function (Blueprint $table) {
            if (Schema::hasColumn('balita_pemeriksaan', 'jenis_imunisasi')) {
                $table->dropColumn('jenis_imunisasi');
            }
        });
    }
};
