<?php

namespace App\Repositories\Customer;

use App\Models\Customer\Customer;

class CustomerRepository
{
    public function __construct(private Customer $customer){}

    public function findOrCreate(string $name, string $phone, string $email): Customer
    {
        $customer = $this->customer->query()
            ->where('phone', $phone)
            ->orWhere('email', $email)
            ->first();

        if ($customer) { return $customer; }

        return $this->customer->query()->create(['name' => $name, 'phone' => $phone, 'email' => $email]);
    }
}
