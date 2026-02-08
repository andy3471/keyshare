<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Enums\LinkedAccountProvider;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Inertia\Response;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/games';

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm(): Response
    {
        return Inertia::render('Auth/Register', [
            'providers'    => LinkedAccountProvider::enabledForFrontend(),
            'pendingGroup' => $this->pendingGroup(),
        ]);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'     => ['required', 'string', 'max:50'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    protected function create(array $data): User
    {
        return User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    /**
     * Load the pending invite group info for the banner.
     *
     * @return array{name: string, avatar: string|null}|null
     */
    private function pendingGroup(): ?array
    {
        $code = session('pending_invite_code');

        if (! $code) {
            return null;
        }

        $group = \App\Models\Group::where('invite_code', $code)->first();

        if (! $group) {
            return null;
        }

        $group->loadMissing('media');

        return [
            'name'   => $group->name,
            'avatar' => $group->avatar_url,
        ];
    }
}
