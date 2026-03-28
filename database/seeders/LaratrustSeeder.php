<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;
use App\Models\User;

class LaratrustSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin role
        $adminRole = Role::firstOrCreate([
            'name' => 'admin',
        ], [
            'display_name' => 'Administrator',
            'description'  => 'Full access to the application',
        ]);

        // Create a sample permission
        $manageUsers = Permission::firstOrCreate([
            'name' => 'manage-users',
        ], [
            'display_name' => 'Manage Users',
            'description'  => 'Create, edit and delete users',
        ]);

        // Attach permission to role
        if (method_exists($adminRole, 'attachPermission')) {
            $adminRole->attachPermission($manageUsers);
        } else {
            $adminRole->permissions()->syncWithoutDetaching([$manageUsers->id]);
        }

        // Attach role to user with id 1 if exists
        $user = User::find(1);
        if ($user) {
            if (method_exists($user, 'attachRole')) {
                $user->attachRole($adminRole);
            } else {
                $user->roles()->syncWithoutDetaching([$adminRole->id]);
            }
        }
    }
}
