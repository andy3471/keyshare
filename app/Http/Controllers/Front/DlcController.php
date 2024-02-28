<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Dlc;
use App\Models\Game;
use Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DlcController extends Controller
{
    // TODO: Needs refactor

    // TODO: Needs refactor
    public function show(Dlc $dlc): View
    {
        $id = $dlc->id;

        $keys = Dlc::find($id)
            ->keys()
            ->select('id', 'platform_id', 'created_user_id')
            ->where('owned_user_id', null)
            ->where('key_type_id', '2')
            ->with('platform', 'createduser')
            ->get();

        return view('dlc.show')->withDlc($dlc)->withKeys($keys);
    }

    public function edit(Dlc $dlc): View
    {
        return view('dlc.edit')->withDlc($dlc);
    }

    // TODO: Use form request
    // TODO: Refactor
    public function update(Request $request): RedirectResponse
    {

        $this->validate($request, [
            'name' => 'required',
            'image' => 'image|nullable|max:1999|dimensions:width=460,height=215',
        ]);

        if ($request->hasFile('image')) {
            $filename = uniqid();
            $extension = $request->file('image')->getClientOriginalExtension();
            $filenameToStore = $filename.'.'.$extension;
            $folderToStore = 'images/dlc/';
            $fullImagePath = $folderToStore.$filenameToStore;

            $path = $request->file('image')->storeAs('public/'.$folderToStore, $filenameToStore);
        }

        $dlc = Dlc::find($request->dlcid);

        $dlc->name = $request->name;
        $dlc->description = $request->description;
        if ($request->hasFile('image')) {
            $dlc->image = 'storage/'.$fullImagePath;
        }

        if (! empty($request->gamename)) {
            $game = Game::firstOrCreate(
                ['name' => $request->gamename],
                ['created_user_id' => Auth::id()]
            );

            $dlc->game_id = $game->id;
        }

        $dlc->save();

        return redirect()->route('dlc', $dlc)->with('message', __('dlc.dlcupdated'));
    }
}
