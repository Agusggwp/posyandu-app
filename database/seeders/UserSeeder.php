<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::where('name', 'admin')->first();
        $kaderRole = Role::where('name', 'kader')->first();
        $bidanRole = Role::where('name', 'bidan')->first();

        User::create([
            'name' => 'Admin Posyandu',
            'email' => 'admin@posyandu.com',
            'password' => Hash::make('password'),
            'role_id' => $adminRole->id,
        ]);

        User::create([
            'name' => 'Kader Posyandu',
            'email' => 'kader@posyandu.com',
            'password' => Hash::make('password'),
            'role_id' => $kaderRole->id,
        ]);

        User::create([
            'name' => 'Bidan Posyandu',
            'email' => 'bidan@posyandu.com',
            'password' => Hash::make('password'),
            'role_id' => $bidanRole->id,
        ]);
    }
}
