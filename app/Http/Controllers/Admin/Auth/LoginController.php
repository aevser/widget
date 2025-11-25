<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function show(): View
    {
        return view('admin.auth.show');
    }

    public function login(AuthRequest $request): RedirectResponse
    {
        if (auth()->attempt($request->validated())) {
            return redirect()->intended(route('tickets.index'));
        }

        return redirect()
            ->back()
            ->withErrors(['email' => 'Неверный email или пароль'])
            ->withInput($request->only('email'));
    }
}
