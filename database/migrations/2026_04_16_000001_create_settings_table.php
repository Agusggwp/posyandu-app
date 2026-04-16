<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->longText('value')->nullable();
            $table->string('type')->default('string'); // string, integer, boolean, array, json
            $table->string('description')->nullable();
            $table->timestamps();

            $table->index('key');
        });

        DB::table('settings')->insert([
            // Center Info
            [
                'key' => 'center_address',
                'value' => '',
                'type' => 'string',
                'description' => 'Alamat pusat kesehatan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'center_email',
                'value' => '',
                'type' => 'string',
                'description' => 'Email pusat kesehatan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'center_hours_open',
                'value' => '08:00',
                'type' => 'string',
                'description' => 'Jam buka pusat kesehatan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'center_hours_close',
                'value' => '16:00',
                'type' => 'string',
                'description' => 'Jam tutup pusat kesehatan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
