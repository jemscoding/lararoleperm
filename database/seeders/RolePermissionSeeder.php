<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
          // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // User Management Permissions
        Permission::create(['name' => 'view users']);
        Permission::create(['name' => 'create users']);
        Permission::create(['name' => 'edit users']);
        Permission::create(['name' => 'delete users']);

        // Blog Post Permissions
        Permission::create(['name' => 'create posts']);
        Permission::create(['name' => 'edit own posts']);
        Permission::create(['name' => 'edit all posts']);
        Permission::create(['name' => 'delete own posts']);
        Permission::create(['name' => 'delete all posts']);
        Permission::create(['name' => 'publish posts']);

        // Blog Comment Permissions
        Permission::create(['name' => 'create comments']);
        Permission::create(['name' => 'edit own comments']);
        Permission::create(['name' => 'edit all comments']);
        Permission::create(['name' => 'delete own comments']);
        Permission::create(['name' => 'delete all comments']);

        // Create Roles
        $adminRole = Role::create(['name' => 'admin']);
        $managerRole = Role::create(['name' => 'manager']);
        $userRole = Role::create(['name' => 'user']);

        // Blog Roles
        $editorRole = Role::create(['name' => 'editor']);
        $authorRole = Role::create(['name' => 'author']);
        $contributorRole = Role::create(['name' => 'contributor']);

        // Assign Permissions to Roles
        $adminRole->givePermissionTo([
            'view users',
            'create users',
            'edit users',
            'delete users',
            'create posts',
            'edit all posts',
            'delete all posts',
            'publish posts',
            'create comments',
            'edit all comments',
            'delete all comments'
        ]);

        $managerRole->givePermissionTo([
            'view users',
            'create users',
            'edit users',
            'create posts',
            'edit all posts',
            'publish posts',
            'create comments'
        ]);

        $editorRole->givePermissionTo([
            'create posts',
            'edit all posts',
            'publish posts',
            'create comments',
            'edit all comments'
        ]);

        $authorRole->givePermissionTo([
            'create posts',
            'edit own posts',
            'delete own posts',
            'create comments',
            'edit own comments',
            'delete own comments'
        ]);

        $contributorRole->givePermissionTo([
            'create posts',
            'create comments',
            'edit own comments'
        ]);

        // Create an admin user
        $adminUser = User::create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('qwerty12345')
        ]);
        $adminUser->assignRole($adminRole);
    }
}
