<?php

namespace App\Http\Controllers\Api\V1\Ticket;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Ticket\CreateTicketRequest;
use App\Services\Ticket\TicketService;
use Illuminate\Http\JsonResponse;

class TicketController extends Controller
{
    public function __construct(private TicketService $ticketService){}

    public function store(CreateTicketRequest $request): JsonResponse
    {
        try {
            $ticket = $this->ticketService->create($request->validated(), attachments: $request->file('files'));

            return response()->json([
                'success' => true,
                'message' => 'Ваша заявка успешно отправлена! Мы свяжемся с вами в ближайшее время.',
                'data' => [
                    'ticket_id' => $ticket->id,
                ]
            ], 201);

        } catch (\Exception $e) {
            \Log::error('Ticket creation error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Произошла ошибка при отправке заявки. Пожалуйста, попробуйте позже.',
            ], 500);
        }
    }
}
