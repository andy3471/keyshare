<?php

namespace App\Http\Controllers\Web\LinkedAccounts;

use App\Models\LinkedAccount;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

abstract class LinkedAccountController
{
    abstract public function driver(): string;

    public function redirect()
    {
        return Socialite::driver($this->driver())->redirect();
    }

    public function callback()
    {
        $remoteUser = Socialite::driver($this->driver())->user();

        $existingUser = LinkedAccount::where('account_id', '=', $remoteUser->id)
            ->where('provider', $this->driver())
            ->first()
            ?->user;

        if (! $existingUser) {
            $existingUser = User::create([
                'name' => $remoteUser->nickname,
                'email' => uniqid(),
                'password' => uniqid(),
            ]);

            $existingUser->linkedAccounts()->create([
                'provider' => $this->driver(),
                'account_id' => $remoteUser->getId(),
            ]);
        }

        Auth::login($existingUser);

        return to_route('games.index');
    }
}
