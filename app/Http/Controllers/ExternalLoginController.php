<?php

namespace App\Http\Controllers;

use App\Models\LinkedAccount;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Socialite;

class ExternalLoginController extends Controller
{

    /**
     * @return mixed
     */
    public function steamRedirect()
    {
        return Socialite::driver('steam')->redirect();
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|string
     */
    public function steamCallback()
    {
        // TODO tidy this
        $steamuser = Socialite::driver('steam')->user();

        $KeyshareUser = LinkedAccount::where('account_id', '=', $steamuser->id)->get();

        if (count($KeyshareUser) == 0) {

            $KeyshareUser = User::create([
                'name' => $steamuser->nickname,
                'image' => $steamuser->avatar,
                'email' => uniqid(),
                'password' => uniqid(),
                'approved' => config('app.auto_approve'),
            ]);


            $LinkedAccount = new LinkedAccount;
                $LinkedAccount->user_id = $KeyshareUser->id;
                $LinkedAccount->linked_account_provider_id = '1';
                $LinkedAccount->account_id = $steamuser->id;
            $LinkedAccount->save();

        } elseif (count($KeyshareUser) == 1) {

            //If Exists, Find and Update User
            $KeyshareUser = User::find($KeyshareUser[0]->user_id);
                $KeyshareUser->name = $steamuser->nickname;
                $KeyshareUser->image = $steamuser->avatar;
            $KeyshareUser->save();

        } else {
            return 'Error';
        }

        Auth::login($KeyshareUser);
        return redirect('/games');
    }

    /**
     * @return mixed
     */
    public function discordRedirect()
    {
        return Socialite::driver('discord')->redirect();
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|string
     */
    public function discordCallback()
    {
        // TODO tidy this
        $discorduser = Socialite::driver('discord')->user();

        $KeyshareUser = LinkedAccount::where('account_id', '=', $discorduser->id)->get();

        if (count($KeyshareUser) == 0) {

            $KeyshareUser = User::create([
                'name' => $discorduser->nickname,
                'image' => $discorduser->avatar,
                'email' => uniqid(),
                'password' => uniqid(),
                'approved' => config('app.auto_approve'),
            ]);


            $LinkedAccount = new LinkedAccount;
                $LinkedAccount->user_id = $KeyshareUser->id;
                $LinkedAccount->linked_account_provider_id = '2';
                $LinkedAccount->account_id = $discorduser->id;
            $LinkedAccount->save();

        } elseif (count($KeyshareUser) == 1) {
            $KeyshareUser = User::find($KeyshareUser[0]->user_id);
                $KeyshareUser->name = $discorduser->nickname;
                $KeyshareUser->image = $discorduser->avatar;
            $KeyshareUser->save();
        } else {
            return 'Error';
        }

        Auth::login($KeyshareUser);
        return redirect('/games');
    }


    /**
     * @return mixed
     */
    public function twitchRedirect()
    {
        return Socialite::driver('twitch')->redirect();
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|string
     */
    public function twitchCallback()
    {
        // TODO tidy this
        $twitchuser = Socialite::driver('twitch')->user();

        $KeyshareUser = LinkedAccount::where('account_id', '=', $twitchuser->id)->get();

        if (count($KeyshareUser) == 0) {

            $KeyshareUser = User::create([
                'name' => $twitchuser->nickname,
                'image' => $twitchuser->avatar,
                'email' => uniqid(),
                'password' => uniqid(),
                'approved' => config('app.auto_approve'),
            ]);


            $LinkedAccount = new LinkedAccount;
                $LinkedAccount->user_id = $KeyshareUser->id;
                $LinkedAccount->linked_account_provider_id = '3';
                $LinkedAccount->account_id = $twitchuser->id;
            $LinkedAccount->save();

        } elseif (count($KeyshareUser) == 1) {
            $KeyshareUser = User::find($KeyshareUser[0]->user_id);
                $KeyshareUser->name = $twitchuser->nickname;
                $KeyshareUser->image = $twitchuser->avatar;
            $KeyshareUser->save();
        } else {
            return 'Error';
        }

        Auth::login($KeyshareUser);
        return redirect('/games');
    }
}
