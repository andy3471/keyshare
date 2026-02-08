<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showLinkRequestForm(): Response
    {
        return Inertia::render('Auth/ForgotPassword');
    }

    protected function sendResetLinkResponse(Request $request, string $response): RedirectResponse
    {
        return redirect()->back()->with('status', 'If that email address is in our system, we\'ll send you a password reset link.');
    }

    protected function sendResetLinkFailedResponse(Request $request, string $response): RedirectResponse
    {
        return redirect()->back()->with('status', 'If that email address is in our system, we\'ll send you a password reset link.');
    }
}
