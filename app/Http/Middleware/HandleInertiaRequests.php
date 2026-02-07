<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\Platform;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $request->user() ? [
                    'id'           => $request->user()->id,
                    'name'         => $request->user()->name,
                    'email'        => $request->user()->email,
                    'image'        => $request->user()->image        ?? null,
                    'bio'          => $request->user()->bio          ?? null,
                    'karma'        => $request->user()->karma !== null ? (int) $request->user()->karma : 0,
                    'karma_colour' => $request->user()->karma_colour ?? 'badge-info',
                    'admin'        => (bool) ($request->user()->admin ?? false),
                    'approved'     => (bool) ($request->user()->approved ?? false),
                ] : null,
            ],
            'platforms' => Cache::remember('platforms', 3600, function () {
                return Platform::all()->map(fn ($platform): array => [
                    'id'   => $platform->id,
                    'name' => $platform->name,
                ])->all();
            }),
            'flash' => [
                'message' => $request->session()->get('message'),
                'error'   => $request->session()->get('error'),
            ],
        ]);
    }
}
