<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminController extends Controller
{
    // TODO split this into a folder
    /**
     * @return \Inertia\Response
     */
    public function usersIndex() {
        $users = User::orderBy('approved')
                    ->paginate(15);

        return Inertia::render('Admin/Users/Index', [
            'users' => $users,
        ]);
    }

    /**
     * @param $id
     * @return \Inertia\Response
     */
    public function usersEdit($id) {
        $user = User::find($id);

        return Inertia::render('Admin/Users/Edit', [
            'auser' => $user,
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function usersUpdate(Request $request) {
        // TODO make this a request + Job

        $this->validate($request, [
            'name' => 'required',
            'image' => 'image|nullable|max:1999|dimensions:ratio=1/1',
            'bio' => 'nullable',
        ]);

        $approved = 0;

        if ($request->approved ) {
            $approved = 1;
        }

        if($request->hasFile('image')){
            $filename = uniqid();
            $extension = $request->file('image')->getClientOriginalExtension();
            $filenameToStore = $filename . '.' . $extension;
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
