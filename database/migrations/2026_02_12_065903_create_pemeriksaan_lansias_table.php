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
        Schema::create('pemeriksaan_lansias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lansia_id')->constrained('lansias')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Petugas
            $table->date('tanggal_pemeriksaan');
            $table->string('tekanan_darah')->nullable();
            $table->decimal('berat_badan', 5, 2)->nullable();
            $table->decimal('tinggi_badan', 5, 2)->nullable();
            $table->integer('gula_darah')->nullable();
            $table->integer('kolesterol')->nullable();
            $table->text('keluhan')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemeriksaan_lansias');
    }
};
