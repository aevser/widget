<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Ticket\TicketRepository;
use Illuminate\View\View;

class TicketController extends Controller
{
    public function __construct(private TicketRepository $ticketRepository){}

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
}
