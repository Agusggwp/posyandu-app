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
            'user-management' => 'User Management',
            'role-management' => 'Role Management',
            'keluarga-management' => 'Keluarga Management',
            'balita-management' => 'Balita Management',
            'ibu-hamil-management' => 'Ibu Hamil Management',
            'lansia-management' => 'Lansia Management',
            'pemeriksaan-balita' => 'Pemeriksaan Balita',
            'pemeriksaan-ibu-hamil' => 'Pemeriksaan Ibu Hamil',
            'pemeriksaan-lansia' => 'Pemeriksaan Lansia',
            'view-reports' => 'View Reports',
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
            'user-management' => 'User Management',
            'role-management' => 'Role Management',
            'keluarga-management' => 'Keluarga Management',
            'balita-management' => 'Balita Management',
            'ibu-hamil-management' => 'Ibu Hamil Management',
            'lansia-management' => 'Lansia Management',
            'pemeriksaan-balita' => 'Pemeriksaan Balita',
            'pemeriksaan-ibu-hamil' => 'Pemeriksaan Ibu Hamil',
            'pemeriksaan-lansia' => 'Pemeriksaan Lansia',
            'view-reports' => 'View Reports',
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
