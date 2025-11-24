<?php

namespace App\Repositories\Ticket;

use App\Models\Ticket\TicketReply;

class TicketReplyRepository
{
    public function __construct(private TicketReply $ticketReply){}

    public function create(int $ticketId, array $data): TicketReply
    {
        return $this->ticketReply->query()->create(['ticket_id' => $ticketId, 'user_id' => $data['user_id'], 'message' => $data['message']]);
    }
}
