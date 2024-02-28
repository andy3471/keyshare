<?php

namespace App\Http\Controllers;

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
        return redirect()->route('games');
    }

    public function index(): View|RedirectResponse
    {
        if (auth()->guest()) {
            return view('auth.login');
        }

        return redirect()->route('games');
    }

    public function notApproved(): View
    {
        return view('auth.notApproved');
    }

    public function demo(): View
    {
        return view('auth.demomode');
    }
}
