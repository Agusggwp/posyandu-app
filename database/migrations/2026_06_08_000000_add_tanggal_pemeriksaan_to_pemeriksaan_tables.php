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
        // Add tanggal_pemeriksaan to balita_pemeriksaan
        Schema::table('balita_pemeriksaan', function (Blueprint $table) {
            if (!Schema::hasColumn('balita_pemeriksaan', 'tanggal_pemeriksaan')) {
                $table->date('tanggal_pemeriksaan')->nullable()->after('umur');
                $table->index('tanggal_pemeriksaan');
            }
        });

        // Add tanggal_pemeriksaan to ibu_hamil_pemeriksaan
        Schema::table('ibu_hamil_pemeriksaan', function (Blueprint $table) {
            if (!Schema::hasColumn('ibu_hamil_pemeriksaan', 'tanggal_pemeriksaan')) {
                $table->date('tanggal_pemeriksaan')->nullable()->after('tinggi_badan');
                $table->index('tanggal_pemeriksaan');
            }
        });

        // Add tanggal_pemeriksaan to dewasa_pemeriksaan
        Schema::table('dewasa_pemeriksaan', function (Blueprint $table) {
            if (!Schema::hasColumn('dewasa_pemeriksaan', 'tanggal_pemeriksaan')) {
                $table->date('tanggal_pemeriksaan')->nullable()->after('waktu_kunjungan');
                $table->index('tanggal_pemeriksaan');
            }
        });

        // Add tanggal_pemeriksaan to nifas_pemeriksaan if table exists
        if (Schema::hasTable('nifas_pemeriksaan')) {
            Schema::table('nifas_pemeriksaan', function (Blueprint $table) {
                if (!Schema::hasColumn('nifas_pemeriksaan', 'tanggal_pemeriksaan')) {
                    $table->date('tanggal_pemeriksaan')->nullable()->after('created_at');
                    $table->index('tanggal_pemeriksaan');
                }
            });
        }

        // Add tanggal_pemeriksaan to remaja_pemeriksaan if table exists
        if (Schema::hasTable('remaja_pemeriksaan')) {
            Schema::table('remaja_pemeriksaan', function (Blueprint $table) {
                if (!Schema::hasColumn('remaja_pemeriksaan', 'tanggal_pemeriksaan')) {
                    $table->date('tanggal_pemeriksaan')->nullable()->after('created_at');
                    $table->index('tanggal_pemeriksaan');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('balita_pemeriksaan', function (Blueprint $table) {
            if (Schema::hasColumn('balita_pemeriksaan', 'tanggal_pemeriksaan')) {
                $table->dropIndex(['tanggal_pemeriksaan']);
                $table->dropColumn('tanggal_pemeriksaan');
            }
        });

        Schema::table('ibu_hamil_pemeriksaan', function (Blueprint $table) {
            if (Schema::hasColumn('ibu_hamil_pemeriksaan', 'tanggal_pemeriksaan')) {
                $table->dropIndex(['tanggal_pemeriksaan']);
                $table->dropColumn('tanggal_pemeriksaan');
            }
        });

        Schema::table('dewasa_pemeriksaan', function (Blueprint $table) {
            if (Schema::hasColumn('dewasa_pemeriksaan', 'tanggal_pemeriksaan')) {
                $table->dropIndex(['tanggal_pemeriksaan']);
                $table->dropColumn('tanggal_pemeriksaan');
            }
        });

        if (Schema::hasTable('nifas_pemeriksaan')) {
            Schema::table('nifas_pemeriksaan', function (Blueprint $table) {
                if (Schema::hasColumn('nifas_pemeriksaan', 'tanggal_pemeriksaan')) {
                    $table->dropIndex(['tanggal_pemeriksaan']);
                    $table->dropColumn('tanggal_pemeriksaan');
                }
            });
        }

        if (Schema::hasTable('remaja_pemeriksaan')) {
            Schema::table('remaja_pemeriksaan', function (Blueprint $table) {
                if (Schema::hasColumn('remaja_pemeriksaan', 'tanggal_pemeriksaan')) {
                    $table->dropIndex(['tanggal_pemeriksaan']);
                    $table->dropColumn('tanggal_pemeriksaan');
                }
            });
        }
    }
};
