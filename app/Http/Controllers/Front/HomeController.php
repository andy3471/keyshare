<?php

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
        return redirect()->route('games.index');
    }

    public function index(): View|RedirectResponse
    {
        if (auth()->guest()) {
            return view('auth.login');
        }

        return redirect()->route('games.index');
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
