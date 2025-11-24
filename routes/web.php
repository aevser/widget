<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;

Route::get('widget', [Controllers\Widget\WidgetController::class, 'show']);

Route::prefix('admin')->group(function () {
    Route::get('tickets', [Controllers\Admin\TicketController::class, 'index'])->name('tickets.index');
    Route::get('tickets/{id}', [Controllers\Admin\TicketController::class, 'show'])->name('tickets.show');
});
