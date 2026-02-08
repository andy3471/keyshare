<?php

declare(strict_types=1);

namespace App\Http\Controllers\Users;

use App\DataTransferObjects\Groups\GroupData;
use App\DataTransferObjects\Users\UserData;
use App\Enums\LinkedAccountProvider;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    public function edit(User $user): Response
    {
        $this->authorize('edit', $user);

        $user->loadMissing(['media', 'linkedAccounts']);

        $linkedProviders = $user->linkedAccounts->pluck('provider')->toArray();

        $providers = array_map(function (LinkedAccountProvider $provider) use ($user, $linkedProviders): array {
            $linked = in_array($provider, $linkedProviders, true);

            return [
                'name'           => $provider->value,
                'label'          => $provider->label(),
                'color'          => $provider->color(),
                'url'            => $provider->redirectUrl(),
                'linked'         => $linked,
                'providerUserId' => $linked
                    ? $user->linkedAccounts->firstWhere('provider', $provider)?->provider_user_id
                    : null,
            ];
        }, LinkedAccountProvider::enabledProviders());

        return Inertia::render('Users/Edit', [
            'user'      => UserData::fromModel($user),
            'providers' => array_values($providers),
        ]);
    }

    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $this->authorize('edit', $user);

        $user->update($request->validated());

        if ($request->hasFile('image')) {
            $user->addMediaFromRequest('image')
                ->toMediaCollection('avatar');
        }

        return to_route('users.show', $user)->with('message', __('auth.profileupdated'));
    }

    public function show(User $user): Response
    {
        $user->loadMissing('media');
        auth()->user()->loadMissing(['media', 'groups']);

        $this->authorize('view', $user);

        $viewer = auth()->user();

        $groups = $user->groups()
            ->withCount('members')
            ->with('media')
            ->get()
            ->filter(fn ($group): bool => $group->is_public || $group->hasMember($viewer))
            ->map(fn (\App\Models\Group $group): GroupData => GroupData::fromModel($group))
            ->values();

        return Inertia::render('Users/Show', [
            'user'   => UserData::fromModel($user),
            'groups' => $groups,
        ]);
    }
}
