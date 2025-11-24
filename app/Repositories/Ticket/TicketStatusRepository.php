<?php

namespace App\Repositories\Ticket;

use App\Constants\Pagination;
use App\Constants\Sort;
use App\Models\Ticket\TicketStatus;
use Illuminate\Pagination\LengthAwarePaginator;

class TicketStatusRepository
{
    public function __construct(private TicketStatus $ticketStatus){}

    public function getAll(): LengthAwarePaginator
    {
        return $this->ticketStatus->query()
            ->orderBy(Sort::SORT_COLUMN_TYPE, Sort::SORT_DESC)
            ->paginate(Pagination::PER_PAGE);
    }

    public function findIdByType(string $type): ?int
    {
        return $this->ticketStatus->query()->where('type', $type)->value('id');
    }
}
