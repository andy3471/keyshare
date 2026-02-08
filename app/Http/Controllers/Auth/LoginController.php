<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Enums\LinkedAccountProvider;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Inertia\Inertia;
use Inertia\Response;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/games';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm(): Response
    {
        return Inertia::render('Auth/Login', [
            'providers'    => LinkedAccountProvider::enabledForFrontend(),
            'pendingGroup' => $this->pendingGroup(),
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
