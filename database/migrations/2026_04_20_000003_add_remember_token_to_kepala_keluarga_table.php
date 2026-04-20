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
        if (! Schema::hasColumn('kepala_keluarga', 'remember_token')) {
            Schema::table('kepala_keluarga', function (Blueprint $table) {
                $table->rememberToken()->nullable()->after('password');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('kepala_keluarga', 'remember_token')) {
            Schema::table('kepala_keluarga', function (Blueprint $table) {
                $table->dropColumn('remember_token');
            });
        }
    }
};
