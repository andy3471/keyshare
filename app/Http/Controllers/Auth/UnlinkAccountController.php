<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Enums\LinkedAccountProvider;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class UnlinkAccountController extends Controller
{
    public function __invoke(LinkedAccountProvider $provider): RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $linkedAccount = $user->linkedAccounts()->where('provider', $provider)->first();

        if (! $linkedAccount) {
            return to_route('users.edit', $user)->with('error', 'No '.$provider->label().' account is linked.');
        }

        $hasPassword        = $user->password && ! str_starts_with($user->email, 'social_');
        $otherAccountsCount = $user->linkedAccounts()->where('provider', '!=', $provider)->count();

        if (! $hasPassword && $otherAccountsCount === 0) {
            return to_route('users.edit', $user)->with('error', 'You cannot unlink your only login method. Set a password and email first.');
        }

        $linkedAccount->delete();

        return to_route('users.edit', $user)->with('message', $provider->label().' account unlinked successfully.');
    }
}
