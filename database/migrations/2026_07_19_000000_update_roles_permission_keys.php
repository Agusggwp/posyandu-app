<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $mapping = [
            'user-management' => ['manage_users', 'manage_roles'],
            'role-management' => ['manage_roles'],
            'keluarga-management' => ['manage_keluarga', 'view_data'],
            'balita-management' => ['manage_balita', 'view_data'],
            'ibu-hamil-management' => ['manage_ibu_hamil', 'view_data'],
            'lansia-management' => ['manage_lansia', 'view_data'],
            'pemeriksaan-balita' => ['manage_pemeriksaan', 'edit_pemeriksaan', 'view_data'],
            'pemeriksaan-ibu-hamil' => ['manage_pemeriksaan', 'edit_pemeriksaan', 'view_data'],
            'pemeriksaan-lansia' => ['manage_pemeriksaan', 'edit_pemeriksaan', 'view_data'],
            'view-reports' => ['view_reports'],
        ];

        $roles = DB::table('roles')->get();

        foreach ($roles as $role) {
            if (empty($role->permissions)) {
                continue;
            }

            $currentPermissions = json_decode($role->permissions, true) ?: [];
            $newPermissions = [];

            foreach ($currentPermissions as $permission) {
                if (isset($mapping[$permission])) {
                    $newPermissions = array_merge($newPermissions, $mapping[$permission]);
                } else {
                    $newPermissions[] = $permission;
                }
            }

            // Remove duplicates and re-index array
            $newPermissions = array_values(array_unique($newPermissions));

            DB::table('roles')
                ->where('id', $role->id)
                ->update(['permissions' => json_encode($newPermissions)]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverting is not strictly necessary since this is a key format correction,
        // but we can leave it empty.
    }
};
