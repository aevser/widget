<?php

namespace App\Services\Ticket;

use App\Repositories\Ticket\TicketRepository;

class TicketValidationService
{
    public function __construct(private TicketRepository $ticketRepository){}

    public function validateLimit(string $phone, string $email): void
    {
        if($this->ticketRepository->hasInLastDay(phone: $phone, email: $email)) {
            abort(response()->json([
                'success' => false,
                'error' => [
                    'message' => 'Ошибка создания заявки. Превышен лимит с данного E-mail / Телефона.'
                ]
            ], 429));
        }
    }
}
