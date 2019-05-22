<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class AdminController extends Controller
{
    public function usersIndex() {
        $users = User::orderBy('approved')
                    ->paginate(15);
        return view('admin.users.index')->withUsers($users);
    }

    public function usersEdit($id) {
        $user = User::find($id);
        return view('admin.users.edit')->withUser($user);
    }

    public function usersUpdate(Request $request) {
        $this->validate($request, [
            'name' => 'required',
            'image' => 'image|nullable|max:1999|dimensions:ratio=1/1',
            'bio' => 'nullable',
        ]);

        if (! $request->approved ) {
            $approved = 0;
        } else {
            $approved = 1;
        }

        if($request->hasFile('image')){
            $filename = uniqid();
            $extension = $request->file('image')->getClientOriginalExtension();
            $filenameToStore = $filename . '.'. $extension;
            $folderToStore = 'images/users/';
            $fullImagePath = $folderToStore . $filenameToStore;

            $path = $request->file('image')->storeAs( 'public/' . $folderToStore , $filenameToStore);
        }

        $user = User::find($request->id);
        $user->name = $request->name;
        $user->bio = $request->bio;
        if($request->hasFile('image')){
            $user->image = '/storage/' . $fullImagePath;
        }
        $user->approved = $approved;
        $user->save();

        return redirect()->route('adminshowusers')->with( 'message', __('admin.profileupdated') );
    }
}
