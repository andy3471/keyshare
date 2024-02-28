<?php

namespace App\Http\Controllers;

use Auth;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function home()
    {
        return redirect()->route('games');
    }

    public function index()
    {
        if (Auth::guest()) {
            return view('auth.login');
        }

        return redirect()->route('games');
    }

    public function notApproved()
    {
        return view('auth.notApproved');
    }

    public function demo()
    {
        return view('auth.demomode');
    }
}
