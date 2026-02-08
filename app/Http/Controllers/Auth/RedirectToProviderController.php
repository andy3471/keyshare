<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Enums\LinkedAccountProvider;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\RedirectResponse as SymfonyRedirectResponse;

class RedirectToProviderController extends Controller
{
    public function __invoke(LinkedAccountProvider $provider): RedirectResponse|SymfonyRedirectResponse
    {
        abort_unless($provider->isEnabled(), 404);

        session(['socialite_intent' => auth()->check() ? 'link' : 'login']);

        return Socialite::driver($provider->driver())->redirect();
    }
}
