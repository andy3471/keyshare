<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use Auth;
use App\User;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    { }

    public function edit()
    {
        return view('users.edit');
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'image' => 'image|nullable|max:1999|dimensions:ratio=1/1',
            'bio' => 'nullable'
        ]);


        if ($request->hasFile('image')) {
            $filename = uniqid();
            $extension = $request->file('image')->getClientOriginalExtension();
            $filenameToStore = $filename . '.' . $extension;
            $folderToStore = 'images/users/';
            $fullImagePath = $folderToStore . $filenameToStore;

            $path = $request->file('image')->storeAs('public/' . $folderToStore, $filenameToStore);
        }

        $user = User::find(auth()->id());
        $user->name = $request->name;
        $user->bio = $request->bio;
        if ($request->hasFile('image')) {
            $user->image = '/storage/' . $fullImagePath;
        }
        $user->save();

        return redirect()->route('showuser', ['id' => auth()->id()])->with('message', __('auth.profileupdated'));
    }
    public function show($id)
    {
        $user = User::find($id);
        return view('users.show')->withUser($user);
    }

    public function passwordResetPage()
    {
        return view('users.changepassword');
    }

    public function passwordResetSave(Request $request)
    {

        $this->validate($request, [
            'currentpassword' => 'required',
            'newpassword' => 'required|string|min:6|confirmed',
        ]);


        if (!(Hash::check($request->currentpassword, Auth::user()->password))) {
            return redirect()->back()->with("error", __('auth.passwordsdontmatch'));
        }

        if ($request->currentpassword == $request->newpassword) {
            return redirect()->back()->with("error", __('auth.passwordsameascurrent'));
        }

        $user = Auth::user();
        $user->password = bcrypt($request->newpassword);
        $user->save();

        return redirect()->back()->with("message", __('auth.passwordchanged'));
    }
}
