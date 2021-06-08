<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\PasswordValidationRules;
use Auth;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Redirect;

class UserController extends Controller
{
    use PasswordValidationRules;

    /**
     * @return \Inertia\Response
     */
    public function setup()
    {
        return Inertia::render('Auth/Setup');
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws \Illuminate\Validation\ValidationException
     */
    public function setupUpdate(Request $request)
    {
        // TODO move to request + job
        $user = Auth::User();
        $this->validate($request, [
            'password' => $this->passwordRules(),
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
        ]);

        if($user->setup_required) {
            $user->forceFill([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->email),
                'setup_required' => false,
            ])->save();

            return Redirect::route('game.index');
        }

        return Redirect::route('keys.create');
    }
}
