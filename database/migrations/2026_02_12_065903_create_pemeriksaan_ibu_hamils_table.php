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
        Schema::create('pemeriksaan_ibu_hamils', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ibu_hamil_id')->constrained('ibu_hamils')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Petugas
            $table->date('tanggal_pemeriksaan');
            $table->integer('usia_kehamilan')->nullable(); // dalam minggu
            $table->string('tekanan_darah')->nullable();
            $table->decimal('berat_badan', 5, 2)->nullable();
            $table->string('lingkar_lengan_atas')->nullable();
            $table->string('tinggi_fundus')->nullable();
            $table->string('denyut_jantung_janin')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemeriksaan_ibu_hamils');
    }
};
