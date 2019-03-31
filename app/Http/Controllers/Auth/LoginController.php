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
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function steamCallback()
    {
        $user = Socialite::driver('steam')->user();

        $findUser = LinkedAccount::where('account_id', '=', $user->id)->get();
        return json_encode($user);
        if ($findUser) {
            $findUser = User::find($findUser[0]->user_id);
        } else {
                // Register Account - Steam does not expose Email accounts, user system needs redeveloping first

                return('Can not yet create new user accounts');
        }

        Auth::login($findUser);
        return redirect('home');
    }
}
