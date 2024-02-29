<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserController extends Controller
{
    public function edit(): View
    {
        return view('users.edit');
    }

    // TODO: Use form request
    // TODO: Refactor

    public function update(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required',
            'image' => 'image|nullable|max:1999|dimensions:ratio=1/1',
            'bio' => 'nullable',
        ]);

        if ($request->hasFile('image')) {
            $filename = uniqid();
            $extension = $request->file('image')->getClientOriginalExtension();
            $filenameToStore = $filename.'.'.$extension;
            $folderToStore = 'images/users/';
            $fullImagePath = $folderToStore.$filenameToStore;

            $path = $request->file('image')->storeAs('public/'.$folderToStore, $filenameToStore);
        }

        $user = auth()->user();
        $user->name = $request->name;
        $user->bio = $request->bio;
        if ($request->hasFile('image')) {
            $user->image = '/storage/'.$fullImagePath;
        }
        $user->save();

        return redirect()->route('showuser', ['id' => auth()->id()])->with('message', __('auth.profileupdated'));
    }

    public function show(User $user): View
    {
        return view('users.show')->withUser($user);
    }

    public function passwordResetPage(): View
    {
        return view('users.change-password');
    }

    // TODO: Use form request
    // TODO: Refactor

    public function passwordResetSave(Request $request): RedirectResponse
    {

        $this->validate($request, [
            'currentpassword' => 'required',
            'newpassword' => 'required|string|min:6|confirmed',
        ]);

        if (! (Hash::check($request->currentpassword, auth()->user()->password))) {
            return redirect()->back()->with('error', __('auth.passwordsdontmatch'));
        }

        if ($request->currentpassword == $request->newpassword) {
            return redirect()->back()->with('error', __('auth.passwordsameascurrent'));
        }

        $user = auth()->user();
        $user->password = bcrypt($request->newpassword);
        $user->save();

        return redirect()->back()->with('message', __('auth.passwordchanged'));
    }
}
