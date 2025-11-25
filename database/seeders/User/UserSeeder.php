<?php

namespace Database\Seeders\User;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admins = [
            ['name' => 'admin', 'email' => '1@1.ru', 'password' => Hash::make('123456')]
        ];

        foreach ($admins as $admin) {
            $admin = User::query()->create($admin);

            $admin->assignRole('admin');

            $admin->givePermissionTo(['tickets.view', 'tickets.show', 'tickets.reply']);
        }

        $managers = [
            ['name' => 'manager', 'email' => '2@2.ru', 'password' => Hash::make('123456')]
        ];

        foreach ($managers as $manager) {
            $manager = User::query()->create($manager);

            $manager->assignRole('manager');

            $manager->givePermissionTo(['tickets.view', 'tickets.show', 'tickets.reply']);
        }
    }
}
