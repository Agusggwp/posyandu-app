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
        Schema::table('kepala_keluarga', function (Blueprint $table) {
            $table->string('password')->nullable()->after('email'); // Password
            $table->timestamp('email_verified_at')->nullable()->after('password'); // Email verification
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending')->after('email_verified_at'); // Status approval
            $table->string('no_nik', 16)->nullable()->unique()->after('no_kk'); // Nomor Identitas Kependudukan
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kepala_keluarga', function (Blueprint $table) {
            $table->dropColumn(['password', 'email_verified_at', 'status', 'no_nik']);
        });
    }
};
