<?php

namespace App\Http\Controllers\Api\V1\Ticket;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Ticket\CreateTicketRequest;
use App\Http\Resources\V1\Ticket\IndexTicketResource;
use App\Services\Ticket\TicketService;
use Illuminate\Http\JsonResponse;

class TicketController extends Controller
{
    public function __construct(private TicketService $ticketService){}

    public function store(CreateTicketRequest $request): JsonResponse
    {
        $result = $this->ticketService->create($request->validated(), attachments: $request->file('files'));

        return response()->json(IndexTicketResource::make($result), JsonResponse::HTTP_CREATED);
    }
}
