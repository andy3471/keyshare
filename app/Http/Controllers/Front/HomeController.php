<?php

declare(strict_types=1);

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

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

    public function index(): View|RedirectResponse
    {
        if (auth()->guest()) {
            return view(\Illuminate\Auth\Events\Login::class);
        }

        return to_route('games.index');
    }

    public function notApproved(): View
    {
        return view('auth.not-approved');
    }

    public function demo(): View
    {
        return view('auth.demo-mode');
    }
}
