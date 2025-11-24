<?php

namespace App\Http\Controllers\Admin\Ticket;

use App\Http\Controllers\Controller;
use App\Http\Requests\Ticket\IndexTicketRequest;
use App\Http\Requests\Ticket\TicketStatus\UpdateTicketStatusRequest;
use App\Http\Requests\V1\Ticket\TicketReply\UpdateManagerReplyRequest;
use App\Repositories\Ticket\TicketReplyRepository;
use App\Repositories\Ticket\TicketRepository;
use App\Repositories\Ticket\TicketStatusRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TicketController extends Controller
{
    public function __construct(
        private TicketRepository $ticketRepository,
        private TicketStatusRepository $ticketStatusRepository,
        private TicketReplyRepository $ticketReplyRepository
    ){}

    public function index(IndexTicketRequest $request): View
    {
        $tickets = $this->ticketRepository->getAll(filters: $request->validated());

        $statuses = $this->ticketStatusRepository->getAll();

        return view('admin.ticket.index', compact('tickets', 'statuses'));
    }

    public function show(int $id): View
    {
        $ticket = $this->ticketRepository->findById(id: $id);

        return view('admin.ticket.show', compact('ticket'));
    }

    public function status(int $id, UpdateTicketStatusRequest $request): RedirectResponse
    {
        $this->ticketRepository->updateStatus(id: $id, statusId: $request->validated('status_id'));

        return redirect()->route('tickets.index');
    }

    public function reply(int $id, UpdateManagerReplyRequest $request): RedirectResponse
    {
         $this->ticketReplyRepository->create(ticketId: $id, data: $request->validated());

         $this->ticketRepository->updateManagerReply(id: $id);

        return redirect()->route('tickets.show', $id);
    }
}
