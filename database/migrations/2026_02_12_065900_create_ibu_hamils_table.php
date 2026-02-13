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
        Schema::create('ibu_hamils', function (Blueprint $table) {
            $table->id();
            $table->foreignId('keluarga_id')->constrained('keluargas')->onDelete('cascade');
            $table->string('nama');
            $table->string('nik')->unique();
            $table->date('tanggal_lahir');
            $table->string('nama_suami');
            $table->date('hpht')->nullable(); // Hari Pertama Haid Terakhir
            $table->date('hpl')->nullable(); // Hari Perkiraan Lahir
            $table->integer('hamil_ke')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ibu_hamils');
    }
};
