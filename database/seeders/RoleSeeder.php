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
                    'manage_users',
                    'manage_roles',
                    'manage_keluarga',
                    'manage_balita',
                    'manage_ibu_hamil',
                    'manage_lansia',
                    'manage_pemeriksaan',
                    'view_reports',
                    'export_data',
                    'manage_settings',
                ]
            ],
            [
                'name' => 'kader',
                'description' => 'Kader Posyandu',
                'permissions' => [
                    'manage_keluarga',
                    'manage_balita',
                    'manage_ibu_hamil',
                    'manage_lansia',
                    'view_reports',
                ]
            ],
            [
                'name' => 'bidan',
                'description' => 'Bidan',
                'permissions' => [
                    'manage_balita',
                    'manage_ibu_hamil',
                    'manage_lansia',
                    'manage_pemeriksaan',
                    'view_reports',
                ]
            ],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
