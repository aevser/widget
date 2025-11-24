<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;

Route::get('widget', [Controllers\Widget\WidgetController::class, 'show']);

Route::prefix('admin')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('login', [Controllers\Admin\Auth\LoginController::class, 'show'])->name('admin.login');

        Route::post('login', [Controllers\Admin\Auth\LoginController::class, 'login'])->name('admin.auth');
    });

    Route::middleware('auth')->group(function () {
        Route::prefix('tickets')->group(function () {
            Route::get('/', [Controllers\Admin\TicketController::class, 'index'])->name('tickets.index');
            Route::get('{id}', [Controllers\Admin\TicketController::class, 'show'])->name('tickets.show');

            Route::patch('{id}/status', [Controllers\Admin\TicketController::class, 'status'])->name('tickets.status');
            Route::post('{id}/reply', [Controllers\Admin\TicketController::class, 'reply'])->name('tickets.reply');
        });
    });
});
