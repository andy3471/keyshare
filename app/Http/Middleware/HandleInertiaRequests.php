<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\DataTransferObjects\Users\UserData;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    protected $rootView = 'app';

    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /** @return array<string, mixed> */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $request->user() ? UserData::from($request->user()) : null,
            ],
            'flash' => [
                'message' => $request->session()->get('message'),
                'error'   => $request->session()->get('error'),
            ],
        ]);
    }
}
