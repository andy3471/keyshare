<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\DataTransferObjects\Groups\GroupData;
use App\DataTransferObjects\Users\UserData;
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

        return Inertia::render('Users/Edit');
    }

    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $this->authorize('edit', $user);

        $user->update($request->validated());

        if ($request->hasFile('image')) {
            $user->addMediaFromRequest('image')
                ->toMediaCollection('avatar');
        }

        return to_route('showuser', ['id' => $user->id])->with('message', __('auth.profileupdated'));
    }

    public function show(User $user): Response
    {
        $this->authorize('view', $user);

        $viewer = auth()->user();

        $groups = $user->groups()
            ->withCount('members')
            ->get()
            ->filter(fn ($group) => $group->is_public || $group->hasMember($viewer))
            ->map(fn ($group) => GroupData::fromModel($group))
            ->values();

        return Inertia::render('Users/Show', [
            'user'   => UserData::fromModel($user),
            'groups' => $groups,
        ]);
    }
}
