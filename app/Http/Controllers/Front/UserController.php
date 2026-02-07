<?php

declare(strict_types=1);

namespace App\Http\Controllers\Front;

use App\DataTransferObjects\UserData;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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

    public function update(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'name'  => 'required',
            'image' => 'image|nullable|max:1999|dimensions:ratio=1/1',
            'bio'   => 'nullable',
        ]);

        if ($request->hasFile('image')) {
            $filename        = uniqid();
            $extension       = $request->file('image')->getClientOriginalExtension();
            $filenameToStore = $filename.'.'.$extension;
            $folderToStore   = 'images/users/';
            $fullImagePath   = $folderToStore.$filenameToStore;

            $path = $request->file('image')->storeAs('public/'.$folderToStore, $filenameToStore);
        }

        $user       = auth()->user();
        $user->name = $request->name;
        $user->bio  = $request->bio;
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

    public function passwordResetPage(): Response
    {
        return Inertia::render('Users/ChangePassword');
    }

    // TODO: Use form request
    // TODO: Refactor

    public function passwordResetSave(Request $request): RedirectResponse
    {

        $this->validate($request, [
            'currentpassword' => 'required',
            'newpassword'     => 'required|string|min:6|confirmed',
        ]);

        if (! (Hash::check($request->currentpassword, auth()->user()->password))) {
            return back()->with('error', __('auth.passwordsdontmatch'));
        }

        if ($request->currentpassword === $request->newpassword) {
            return back()->with('error', __('auth.passwordsameascurrent'));
        }

        $user           = auth()->user();
        $user->password = bcrypt($request->newpassword);
        $user->save();

        return back()->with('message', __('auth.passwordchanged'));
    }
}
