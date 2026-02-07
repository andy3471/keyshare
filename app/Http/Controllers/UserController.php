<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\DataTransferObjects\Users\UserData;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    public function edit(): Response
    {
        return Inertia::render('Users/Edit');
    }

    public function update(UpdateUserRequest $request): RedirectResponse
    {
        $user = auth()->user()->update($request->validated());

        if ($request->hasFile('image')) {
            $user->addMediaFromRequest('image')
                ->toMediaCollection('avatar');
        }

        return to_route('showuser', ['id' => auth()->id()])->with('message', __('auth.profileupdated'));
    }

    public function show(User $user): Response
    {
        return Inertia::render('Users/Show', [
            'user' => UserData::fromModel($user),
        ]);
    }
}
