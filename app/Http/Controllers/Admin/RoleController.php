<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Role;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    /**
     * Display a listing of roles
     */
    public function index()
    {
        $roles = Role::withCount('users')->get();
        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new role
     */
    public function create()
    {
        $availablePermissions = [
            'manage_users' => 'User Management',
            'manage_roles' => 'Role Management',
            'manage_keluarga' => 'Keluarga Management',
            'manage_balita' => 'Balita Management',
            'manage_ibu_hamil' => 'Ibu Hamil & Nifas Management',
            'manage_lansia' => 'Remaja & Lansia Management',
            'manage_pemeriksaan' => 'Input Pemeriksaan',
            'edit_pemeriksaan' => 'Edit Pemeriksaan',
            'view_data' => 'View Health Data',
            'view_reports' => 'View Reports',
            'delete_data' => 'Delete Data',
            'export_data' => 'Export Data',
            'manage_settings' => 'Manage Settings',
        ];

        return view('admin.roles.create', compact('availablePermissions'));
    }

    /**
     * Store a newly created role
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'description' => 'nullable|string',
            'permissions' => 'nullable|array',
        ]);

        $role = Role::create($validated);

        ActivityLog::log('created', "Created new role: {$role->name}", 'Role', $role->id);

        return redirect()->route('roles.index')
            ->with('success', 'Role berhasil ditambahkan');
    }

    /**
     * Show the form for editing the specified role
     */
    public function edit(Role $role)
    {
        $availablePermissions = [
            'manage_users' => 'User Management',
            'manage_roles' => 'Role Management',
            'manage_keluarga' => 'Keluarga Management',
            'manage_balita' => 'Balita Management',
            'manage_ibu_hamil' => 'Ibu Hamil & Nifas Management',
            'manage_lansia' => 'Remaja & Lansia Management',
            'manage_pemeriksaan' => 'Input Pemeriksaan',
            'edit_pemeriksaan' => 'Edit Pemeriksaan',
            'view_data' => 'View Health Data',
            'view_reports' => 'View Reports',
            'delete_data' => 'Delete Data',
            'export_data' => 'Export Data',
            'manage_settings' => 'Manage Settings',
        ];

        return view('admin.roles.edit', compact('role', 'availablePermissions'));
    }

    /**
     * Update the specified role
     */
    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'description' => 'nullable|string',
            'permissions' => 'nullable|array',
        ]);

        $oldData = $role->toArray();
        $role->update($validated);

        ActivityLog::log('updated', "Updated role: {$role->name}", 'Role', $role->id, [
            'old' => $oldData,
            'new' => $role->toArray()
        ]);

        return redirect()->route('roles.index')
            ->with('success', 'Role berhasil diperbarui');
    }

    /**
     * Remove the specified role
     */
    public function destroy(Role $role)
    {
        // Prevent deletion of default roles
        if (in_array($role->name, ['Admin', 'Kader', 'Bidan'])) {
            return redirect()->route('roles.index')
                ->with('error', 'Role default tidak dapat dihapus');
        }

        // Check if role has users
        if ($role->users()->count() > 0) {
            return redirect()->route('roles.index')
                ->with('error', 'Tidak dapat menghapus role yang masih memiliki user');
        }

        ActivityLog::log('deleted', "Deleted role: {$role->name}", 'Role', $role->id);

        $role->delete();

        return redirect()->route('roles.index')
            ->with('success', 'Role berhasil dihapus');
    }
}
