<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    protected $redirectTo = '/games';

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showResetForm(Request $request, ?string $token = null): Response
    {
        return Inertia::render('Auth/ResetPassword', [
            'token' => $token,
            'email' => $request->input('email', ''),
        ]);
    }
}
