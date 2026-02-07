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

    // TODO: Use form request
    // TODO: Refactor

    public function update(UpdateUserRequest $request): RedirectResponse
    {
        if ($request->hasFile('image')) {
            $filename        = uniqid();
            $extension       = $request->file('image')->getClientOriginalExtension();
            $filenameToStore = $filename.'.'.$extension;
            $folderToStore   = 'images/users/';
            $fullImagePath   = $folderToStore.$filenameToStore;

            $path = $request->file('image')->storeAs('public/'.$folderToStore, $filenameToStore);
        }

        $user = auth()->user()->update($request->validated());

        if ($request->hasFile('image')) {
            $user->image = '/storage/'.$fullImagePath;
        }

        $user->save();

        return to_route('showuser', ['id' => auth()->id()])->with('message', __('auth.profileupdated'));
    }

    public function show(User $user): Response
    {
        return Inertia::render('Users/Show', [
            'user' => UserData::fromModel($user),
        ]);
    }
}
