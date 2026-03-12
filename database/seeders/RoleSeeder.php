<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'admin',
                'description' => 'Administrator sistem - Full Access',
                'permissions' => [
                    'manage_users',        // Mengelola akun pengguna
                    'manage_roles',        // Mengelola role
                    'manage_keluarga',     // Menginput data ibu/keluarga
                    'manage_balita',       // Menginput data balita
                    'manage_ibu_hamil',    // Menginput data ibu hamil
                    'manage_lansia',       // Menginput data lansia
                    'manage_pemeriksaan',  // Menginput data pemeriksaan kesehatan
                    'edit_pemeriksaan',    // Mengedit data pemeriksaan
                    'view_data',           // Melihat data kesehatan
                    'view_reports',        // Melihat laporan posyandu
                    'delete_data',         // Menghapus data
                    'export_data',         // Export data
                    'manage_settings',     // Kelola pengaturan sistem
                ]
            ],
            [
                'name' => 'kader',
                'description' => 'Kader Posyandu - Input data warga',
                'permissions' => [
                    'manage_keluarga',     // Menginput data ibu/keluarga
                    'manage_balita',       // Menginput data balita
                    'manage_ibu_hamil',    // Menginput data ibu hamil
                    'manage_lansia',       // Menginput data lansia
                    'view_data',           // Melihat data kesehatan
                    'view_reports',        // Melihat laporan posyandu
                ]
            ],
            [
                'name' => 'bidan',
                'description' => 'Bidan - Pemeriksaan kesehatan',
                'permissions' => [
                    'manage_pemeriksaan',  // Menginput data pemeriksaan kesehatan
                    'edit_pemeriksaan',    // Mengedit data pemeriksaan
                    'view_data',           // Melihat data kesehatan
                    'view_reports',        // Melihat laporan posyandu
                ]
            ],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
