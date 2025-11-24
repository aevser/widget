<?php

use App\Http\Controllers\Api\V1\Ticket\TicketController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1;

Route::prefix('v1')->group(function () {
    Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
});
