<?php

namespace Database\Seeders\Ticket;

use App\Models\Customer\Customer;
use App\Models\Ticket\Ticket;
use Illuminate\Database\Seeder;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = Customer::all();
        $faker = \Faker\Factory::create();

        foreach ($customers as $customer) {
            for ($i = 0; $i < 5; $i++) {
                Ticket::query()->create([
                    'customer_id' => $customer->id,
                    'status_id' => $faker->randomElement([1, 2, 3]),
                    'subject' => $faker->sentence,
                    'message' => $faker->paragraph
                ]);
            }
        }
    }
}
