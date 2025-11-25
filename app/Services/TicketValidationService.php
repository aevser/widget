<?php

namespace App\Services;

use App\Repositories\Ticket\TicketRepository;

class TicketValidationService
{
    public function __construct(private TicketRepository $ticketRepository){}

    public function hasLimit(string $phone, string $email): ?array
    {
        if($this->ticketRepository->hasInLastDay(phone: $phone, email: $email)) {

            return [
                'success' => false,
                'error' => [
                    'message' => 'Ошибка создания заявки. Превышен лимит с данного E-mail / Телефона.'
                ],
                'code' => 429
            ];
        }

        return null;
    }
}
