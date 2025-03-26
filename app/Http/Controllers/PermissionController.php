<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permissions = Permission::paginate(10);
        return view('permissions.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return view('permissions.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:permissions,name',
            'guard_name' => 'sometimes|in:web,api',
            'description' => 'nullable|string|max:255',
            'roles' => 'sometimes|array'
        ]);

        $permission = Permission::create([
            'name' => $validatedData['name'],
            'guard_name' => $validatedData['guard_name'] ?? 'web',
            'description' => $validatedData['description'] ?? null
        ]);

        // Assign to roles if specified
        if (!empty($validatedData['roles'])) {
            foreach ($validatedData['roles'] as $roleName) {
                $role = Role::findByName($roleName);
                $role->givePermissionTo($permission);
            }
        }

        return redirect()->route('permissions.index')
            ->with('success', 'Permission created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Permission $permission)
    {
        // Get roles with this permission
        $roles = Role::whereHas('permissions', function($query) use ($permission) {
            $query->where('id', $permission->id);
        })->paginate(10);

        return view('permissions.show', compact('permission', 'roles'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission)
    {
        $roles = Role::all();
        return view('permissions.edit', compact('permission', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $permission)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:permissions,name,' . $permission->id,
            'description' => 'nullable|string|max:255',
            'roles' => 'sometimes|array'
        ]);

        $permission->update([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'] ?? null
        ]);

        // Sync roles
        if (!empty($validatedData['roles'])) {
            // Remove from all current roles
            $currentRoles = Role::all();
            foreach ($currentRoles as $role) {
                $role->revokePermissionTo($permission);
            }

            // Add to specified roles
            foreach ($validatedData['roles'] as $roleName) {
                $role = Role::findByName($roleName);
                $role->givePermissionTo($permission);
            }
        }

        return redirect()->route('permissions.index')
            ->with('success', 'Permission updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        // Prevent deletion of critical permissions
        $criticalPermissions = [
            'view users', 'create users', 'edit users', 'delete users'
        ];

        if (in_array($permission->name, $criticalPermissions)) {
            return redirect()->route('permissions.index')
                ->with('error', 'Cannot delete critical system permissions.');
        }

        $permission->delete();

        return redirect()->route('permissions.index')
            ->with('success', 'Permission deleted successfully.');
    }
}
