<?php

namespace App\Http\Controllers\Widget;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class WidgetController extends Controller
{
    public function show(): View
    {
        return view('widget.show');
    }
}
