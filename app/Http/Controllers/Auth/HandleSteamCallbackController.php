<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\LinkedAccount;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class HandleSteamCallbackController extends Controller
{
    // TODO: Refactor this
    public function __invoke(): RedirectResponse|string
    {
        $steamuser = Socialite::driver('steam')->user();

        $sparekeyUser = LinkedAccount::where('account_id', '=', $steamuser->id)->get();

        if (count($sparekeyUser) === 0) {

            $sparekeyUser = User::create([
                'name'     => $steamuser->nickname,
                'image'    => $steamuser->avatar,
                'email'    => uniqid(),
                'password' => uniqid(),
            ]);

            $LinkedAccount                             = new LinkedAccount;
            $LinkedAccount->user_id                    = $sparekeyUser->id;
            $LinkedAccount->linked_account_provider_id = '1';
            $LinkedAccount->account_id                 = $steamuser->id;
            $LinkedAccount->save();

        } elseif (count($sparekeyUser) === 1) {

            // If Exists, Find and Update User
            $sparekeyUser        = User::find($sparekeyUser[0]->user_id);
            $sparekeyUser->name  = $steamuser->nickname;
            $sparekeyUser->image = $steamuser->avatar;
            $sparekeyUser->save();

        } else {
            return 'Error';
        }

        Auth::login($sparekeyUser);

        return to_route('games.index');
    }
}
