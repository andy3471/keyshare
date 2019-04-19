<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Socialite;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\LinkedAccount;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/games';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function steamRedirect()
    {
        return Socialite::driver('steam')->redirect();
    }


    /**
     * Obtain the user information from Steam.
     *
     * @return \Illuminate\Http\Response
     */
    public function steamCallback()
    {
        $steamuser = Socialite::driver('steam')->user();

        $KeyshareUser = LinkedAccount::where('account_id', '=', $steamuser->id)->get();

        if (count($KeyshareUser) == 0) {
            //If Doesn't Exist, Create User
            $KeyshareUser = new User;
            $KeyshareUser->name = $steamuser->nickname;
            $KeyshareUser->image = $steamuser->avatar;
            $KeyshareUser->email = uniqid();
            $KeyshareUser->password = uniqid();
            $KeyshareUser->save();

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
}
