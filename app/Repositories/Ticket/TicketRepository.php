<?php

namespace App\Repositories\Ticket;

use App\Constants\Pagination;
use App\Constants\Sort;
use App\Models\Ticket\Ticket;
use Illuminate\Pagination\LengthAwarePaginator;

class TicketRepository
{
    public function __construct(private Ticket $ticket){}

    public function getAll(): LengthAwarePaginator
    {
        return $this->ticket->query()
            ->orderBy(Sort::SORT_COLUMN, Sort::SORT_DESC)
            ->paginate(Pagination::PER_PAGE);
    }

    public function getOne(int $id): Ticket
    {
        return $this->ticket->query()->findOrFail($id);
    }

    public function create(?int $user_id, int $customer_id, int $status_id, string $subject, string $message, ?string $manager_replied_at): Ticket
    {
        return $this->ticket->query()->create([
            'user_id' => $user_id,
            'customer_id' => $customer_id,
            'status_id' => $status_id,
            'subject' => $subject,
            'message' => $message,
            'manager_replied_at' => $manager_replied_at
        ]);
    }
}
