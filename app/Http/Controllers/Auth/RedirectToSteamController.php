<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\RedirectResponse as SymfonyRedirectResponse;

class RedirectToSteamController extends Controller
{
    public function __invoke(): RedirectResponse|SymfonyRedirectResponse
    {
        return Socialite::driver('steam')->redirect();
    }
}
