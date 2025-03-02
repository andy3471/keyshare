<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class ConfirmablePasswordController extends Controller
{
    public function show(): Response
    {
        return Inertia::render('auth/ConfirmPassword');
    }

    public function store(Request $request): RedirectResponse
    {
        throw_unless(Auth::guard('web')->validate([
            'email' => $request->user()->email,
            'password' => $request->password,
        ]), ValidationException::withMessages([
            'password' => __('auth.password'),
        ]));

        $request->session()->put('auth.password_confirmed_at', now()->timestamp);

        return redirect()->intended(route('dashboard', absolute: false));
    }
}
