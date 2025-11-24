<?php

namespace App\Models\Customer;

use App\Models\Ticket\Ticket;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    protected $fillable = ['name', 'email', 'phone'];

    // Связи

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }
}
