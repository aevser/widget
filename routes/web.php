<?php

use App\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::get('widget', [Controllers\Widget\WidgetController::class, 'show']);

Route::prefix('admin')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('login', [Controllers\Admin\Auth\LoginController::class, 'show'])->name('admin.login');

        Route::post('login', [Controllers\Admin\Auth\LoginController::class, 'login'])->name('admin.auth');
    });

    Route::middleware(\App\Http\Middleware\RedirectIfUnauthenticated::class)->group(function () {
        Route::prefix('tickets')->group(function () {
            Route::get('/', [Controllers\Admin\Ticket\TicketController::class, 'index'])->name('tickets.index');

            Route::get('{id}', [Controllers\Admin\Ticket\TicketController::class, 'show'])->name('tickets.show');

            Route::patch('{id}/status', [Controllers\Admin\Ticket\TicketController::class, 'status'])->name('tickets.status');

            Route::post('{id}/reply', [Controllers\Admin\Ticket\TicketController::class, 'reply'])->name('tickets.reply');

            Route::get('{id}/attachment/{media}/download', [Controllers\Admin\Ticket\TicketController::class, 'download'])->name('tickets.attachment.download');
        });

        Route::get('statistic', [Controllers\Admin\Statistic\StatisticController::class, 'index'])->name('statistic.index');

        Route::post('logout', [Controllers\Admin\Auth\LogoutController::class, 'logout'])->name('admin.logout');
    });
});
