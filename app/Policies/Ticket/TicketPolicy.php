<?php

namespace App\Policies\Ticket;

use App\Models\User;

class TicketPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct(){}

    public function view(User $user): bool
    {
        return $user->hasPermissionTo('tickets.show');
    }

    public function reply(User $user): bool
    {
        return $user->hasPermissionTo('tickets.reply');
    }
}
