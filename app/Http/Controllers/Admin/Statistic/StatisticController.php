<?php

namespace App\Http\Controllers\Admin\Statistic;

use App\Http\Controllers\Controller;
use App\Repositories\Ticket\TicketRepository;
use Illuminate\View\View;

class StatisticController extends Controller
{
    public function __construct(private TicketRepository $ticketRepository){}

    public function index(): View
    {
        $day = $this->ticketRepository->findByDay();

        $week = $this->ticketRepository->findByWeek();

        $month = $this->ticketRepository->findByMonth();

        return view('admin.statistic.index', compact('day', 'week', 'month'));
    }
}
