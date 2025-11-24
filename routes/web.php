<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Widget;

Route::get('widget', [Widget\WidgetController::class, 'show']);
