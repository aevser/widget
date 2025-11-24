<?php

namespace App\Repositories\Ticket;

use App\Constants\Sort;
use App\Models\Ticket\TicketStatus;
use Illuminate\Database\Eloquent\Collection;

class TicketStatusRepository
{
    public function __construct(private TicketStatus $ticketStatus){}

    public function getAll(): Collection
    {
        return $this->ticketStatus->query()
            ->orderBy(Sort::SORT_COLUMN_TYPE, Sort::SORT_DESC)
            ->get();
    }

    public function findIdByType(string $type): ?int
    {
        return $this->ticketStatus->query()->where('type', $type)->value('id');
    }
}
