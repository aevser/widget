<?php

namespace Database\Seeders\Customer;

use App\Models\Customer\Customer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i <= 9; $i++) {
            Customer::query()->create(['name' => 'user' . $i, 'phone' => '+7999999999' . $i, 'email' => 'user' . $i . '@gmail.com']);
        }
    }
}
