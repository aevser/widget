<?php

namespace Database\Seeders;

use Database\Seeders\Customer\CustomerSeeder;
use Database\Seeders\Ticket\TicketSeeder;
use Database\Seeders\User\Role\RoleSeeder;
use Database\Seeders\User\UserSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(CustomerSeeder::class);
        $this->call(TicketSeeder::class);
    }
}
