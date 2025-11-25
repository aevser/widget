<?php

namespace Database\Seeders\User\Role;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

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
                'guard_name' => 'web'
            ],
            [
                'name' => 'manager',
                'guard_name' => 'web'
            ],
            [
                'name' => 'user',
                'guard_name' => 'web'
            ]
        ];

        foreach ($roles as $role) {
            Role::query()->create($role);
        }
    }
}
