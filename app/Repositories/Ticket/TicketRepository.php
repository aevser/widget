<?php

namespace App\Repositories\Ticket;

use App\Constants\Pagination;
use App\Constants\Sort;
use App\Models\Ticket\Ticket;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;

class TicketRepository
{
    private const array RELATIONS = ['customer', 'status', 'replies'];

    public function __construct(private Ticket $ticket){}

    public function getAll(array $filters): LengthAwarePaginator
    {
        return $this->ticket->query()
            ->with(self::RELATIONS)
            ->applyFilters($filters)
            ->orderBy(Sort::SORT_COLUMN_ID, Sort::SORT_DESC)
            ->paginate($filters['perPage'] ?? Pagination::PER_PAGE);
    }

    public function getOne(int $id): Ticket
    {
        return $this->ticket->query()->with(self::RELATIONS)->findOrFail($id);
    }

    public function create($customerId, int $statusId, string $subject, string $message): Ticket
    {
        return $this->ticket->query()->create(['customer_id' => $customerId, 'status_id' => $statusId, 'subject' => $subject, 'message' => $message]);
    }

    public function updateStatus(int $id, int $statusId): Ticket
    {
        $ticket = $this->ticket->query()->findOrFail($id);

        $ticket->update(['status_id' => $statusId]);

        return $ticket->fresh(self::RELATIONS);
    }

    public function updateManagerReply(int $id): Ticket
    {
        $ticket = $this->ticket->query()->findOrFail($id);

        $ticket->update(['manager_replied_at' => Carbon::now()]);

        return $ticket->fresh(self::RELATIONS);
    }
}
