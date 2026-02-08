<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Enums\LinkedAccountProvider;
use App\Http\Controllers\Controller;
use App\Models\LinkedAccount;
use App\Models\User;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class HandleProviderCallbackController extends Controller
{
    public function __invoke(Request $request, LinkedAccountProvider $provider): RedirectResponse
    {
        abort_unless($provider->isEnabled(), 404);

        if ($request->has('error')) {
            $intent = session()->pull('socialite_intent', 'login');

            $destination = $intent === 'link' && Auth::check()
                ? to_route('users.edit', Auth::user())
                : to_route('login');

            return $destination->with('error', 'Authentication with '.$provider->label().' was cancelled or failed.');
        }

        try {
            $socialiteUser = Socialite::driver($provider->driver())->user();
        } catch (ClientException) {
            $intent = session()->pull('socialite_intent', 'login');

            $destination = $intent === 'link' && Auth::check()
                ? to_route('users.edit', Auth::user())
                : to_route('login');

            return $destination->with('error', 'Failed to authenticate with '.$provider->label().'. Please try again.');
        }

        $intent = session()->pull('socialite_intent', 'login');

        $providerData = array_filter([
            'nickname'    => $socialiteUser->getNickname(),
            'name'        => $socialiteUser->getName(),
            'email'       => $socialiteUser->getEmail(),
            'avatar'      => $socialiteUser->getAvatar(),
            'profile_url' => $socialiteUser->user['profileurl'] ?? null,
        ]);

        if ($intent === 'link' && Auth::check()) {
            return $this->linkAccount(Auth::user(), $provider, $socialiteUser->getId(), $providerData);
        }

        return $this->loginOrRegister($provider, $socialiteUser->getId(), $providerData);
    }

    /**
     * Link a provider account to an already-authenticated user.
     *
     * @param  array<string, mixed>  $providerData
     */
    private function linkAccount(User $user, LinkedAccountProvider $provider, string $providerUserId, array $providerData): RedirectResponse
    {
        $existingAccount = LinkedAccount::query()
            ->where('provider', $provider)
            ->where('provider_user_id', $providerUserId)
            ->first();

        if ($existingAccount && $existingAccount->user_id !== $user->id) {
            return to_route('users.edit', $user)->with('error', 'This '.$provider->label().' account is already linked to a different user.');
        }

        if ($user->linkedAccounts()->where('provider', $provider)->exists()) {
            return to_route('users.edit', $user)->with('error', 'You already have a '.$provider->label().' account linked.');
        }

        $user->linkedAccounts()->create([
            'provider'         => $provider,
            'provider_user_id' => $providerUserId,
            'data'             => $providerData,
        ]);

        return to_route('users.edit', $user)->with('message', $provider->label().' account linked successfully.');
    }

    /**
     * Find an existing linked account and log in, or create a new user.
     *
     * @param  array<string, mixed>  $providerData
     */
    private function loginOrRegister(LinkedAccountProvider $provider, string $providerUserId, array $providerData): RedirectResponse
    {
        $linkedAccount = LinkedAccount::query()
            ->where('provider', $provider)
            ->where('provider_user_id', $providerUserId)
            ->first();

        if ($linkedAccount) {
            $linkedAccount->update(['data' => $providerData]);

            Auth::login($linkedAccount->user, remember: true);

            return to_route('games.index');
        }

        $displayName = $providerData['nickname'] ?? $providerData['name'] ?? $provider->label().' User';

        $user = User::create([
            'name'     => $displayName,
            'email'    => 'social_'.Str::random(16).'@placeholder.local',
            'password' => Str::random(64),
        ]);

        $user->linkedAccounts()->create([
            'provider'         => $provider,
            'provider_user_id' => $providerUserId,
            'data'             => $providerData,
        ]);

        Auth::login($user, remember: true);

        return to_route('games.index');
    }
}
