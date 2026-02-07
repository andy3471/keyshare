<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class WelcomeController extends Controller
{
    public function __invoke(): Response|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('games.index');
        }

        return Inertia::render('Welcome');
    }
}
