<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Inertia\Inertia;
use Inertia\Response;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/games';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm(): Response
    {
        return Inertia::render('Auth/Login', [
            'steamLoginEnabled' => config('keyshare.steamlogin', false),
            'canResetPassword'  => true,
        ]);
    }
}
