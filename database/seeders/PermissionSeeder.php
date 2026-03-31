<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        Permission::updateOrCreate(
            ['name' => 'create-user'],
            ['display_name' => 'Create User']
        );

        Permission::updateOrCreate(
            ['name' => 'edit-user'],
            ['display_name' => 'Edit User']
        );

        Permission::updateOrCreate(
            ['name' => 'delete-user'],
            ['display_name' => 'Delete User']
        );

        Permission::updateOrCreate(
            ['name' => 'view-user'],
            ['display_name' => 'View User']
        );
    }
}