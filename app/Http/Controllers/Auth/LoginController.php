<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\LinkedAccount;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Socialite;

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

            if (config('keyshare.autoapproveusers') == 1) {
                $approved = 1;
            } else {
                $approved = 0;
            }

            $KeyshareUser = User::create([
                'name' => $steamuser->nickname,
                'image' => $steamuser->avatar,
                'email' => uniqid(),
                'password' => uniqid(),
                'approved' => $approved,
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
}
