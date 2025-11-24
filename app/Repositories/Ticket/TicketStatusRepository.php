<?php

namespace App\Repositories\Ticket;

use App\Models\Ticket\TicketStatus;

class TicketStatusRepository
{
    public function __construct(private TicketStatus $ticketStatus){}

    public function findIdByType(string $type): ?int
    {
        return $this->ticketStatus->query()->where('type', $type)->value('id');
    }
}
