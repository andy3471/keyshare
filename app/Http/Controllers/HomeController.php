<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function home(): RedirectResponse
    {
        return to_route('games.index');
    }

    public function index(): RedirectResponse
    {
        return to_route('games.index');
    }

    public function notApproved(): Response
    {
        return Inertia::render('Auth/NotApproved');
    }

    public function demo(): Response
    {
        return Inertia::render('Auth/DemoMode');
    }
}
