<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::updateOrCreate(
            ['name' => 'admin'],
            ['display_name' => 'Admin']
        );

        Role::updateOrCreate(
            ['name' => 'user'],
            ['display_name' => 'User']
        );
    }
}