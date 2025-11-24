<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Ticket\UpdateManagerReplyRequest;
use App\Repositories\Ticket\TicketReplyRepository;
use App\Repositories\Ticket\TicketRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TicketController extends Controller
{
    public function __construct(private TicketRepository $ticketRepository, private TicketReplyRepository $ticketReplyRepository){}

    public function index(): View
    {
        $tickets = $this->ticketRepository->getAll();

        return view('admin.ticket.index', compact('tickets'));
    }

    public function show(int $id): View
    {
        $ticket = $this->ticketRepository->getOne(id: $id);

        return view('admin.ticket.show', compact('ticket'));
    }

    public function reply(int $id, UpdateManagerReplyRequest $request): RedirectResponse
    {
         $this->ticketReplyRepository->create(ticketId: $id, data: $request->validated());

         $this->ticketRepository->update(id: $id);

        return redirect()->route('tickets.show', $id);
    }
}
