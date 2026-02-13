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
        Schema::create('pemeriksaan_balitas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('balita_id')->constrained('balitas')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Petugas
            $table->date('tanggal_pemeriksaan');
            $table->decimal('berat_badan', 5, 2);
            $table->decimal('tinggi_badan', 5, 2);
            $table->decimal('lingkar_kepala', 5, 2)->nullable();
            $table->string('imunisasi')->nullable();
            $table->string('vitamin')->nullable();
            $table->enum('status_gizi', ['normal', 'kurang', 'stunting'])->default('normal');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemeriksaan_balitas');
    }
};
