<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Models\LinkedAccount;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SteamLoginController
{
    public function redirect()
    {
        return Socialite::driver('steam')->redirect();
    }

    // TODO: Refactor this
    public function callback()
    {
        $steamuser = Socialite::driver('steam')->user();

        $KeyshareUser = LinkedAccount::where('account_id', '=', $steamuser->id)->get();

        if (count($KeyshareUser) === 0) {

            $KeyshareUser = User::create([
                'name'     => $steamuser->nickname,
                'image'    => $steamuser->avatar,
                'email'    => uniqid(),
                'password' => uniqid(),
            ]);

            $LinkedAccount                             = new LinkedAccount;
            $LinkedAccount->user_id                    = $KeyshareUser->id;
            $LinkedAccount->linked_account_provider_id = '1';
            $LinkedAccount->account_id                 = $steamuser->id;
            $LinkedAccount->save();

        } elseif (count($KeyshareUser) === 1) {

            // If Exists, Find and Update User
            $KeyshareUser        = User::find($KeyshareUser[0]->user_id);
            $KeyshareUser->name  = $steamuser->nickname;
            $KeyshareUser->image = $steamuser->avatar;
            $KeyshareUser->save();

        } else {
            return 'Error';
        }

        Auth::login($KeyshareUser);

        return to_route('games.index');
    }
}
