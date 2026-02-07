<?php

declare(strict_types=1);

namespace App\Http\Controllers\Front;

use App\DataTransferObjects\DlcData;
use App\DataTransferObjects\KeyData;
use App\Http\Controllers\Controller;
use App\Models\Dlc;
use App\Models\Game;
use App\Models\KeyType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DlcController extends Controller
{
    // TODO: Needs refactor

    // TODO: Needs refactor
    public function show(Dlc $dlc): Response
    {
        $keys = $dlc->keys()
            ->select('id', 'platform_id', 'created_user_id')
            ->where('owned_user_id')
            ->where('key_type_id', KeyType::getIdByName('DLC'))
            ->with('platform', 'createdUser')
            ->get()
            ->map(fn (\App\Models\Key $key): KeyData => KeyData::fromModel($key));

        $dlc->load('game');

        return Inertia::render('Dlc/Show', [
            'dlc'  => DlcData::fromModel($dlc),
            'keys' => $keys->toArray(),
        ]);
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
            'name'  => 'required',
            'image' => 'image|nullable|max:1999|dimensions:width=460,height=215',
        ]);

        if ($request->hasFile('image')) {
            $filename        = uniqid();
            $extension       = $request->file('image')->getClientOriginalExtension();
            $filenameToStore = $filename.'.'.$extension;
            $folderToStore   = 'images/dlc/';
            $fullImagePath   = $folderToStore.$filenameToStore;

            $path = $request->file('image')->storeAs('public/'.$folderToStore, $filenameToStore);
        }

        $dlc = Dlc::find($request->dlcid);

        $dlc->name        = $request->name;
        $dlc->description = $request->description;
        if ($request->hasFile('image')) {
            $dlc->image = 'storage/'.$fullImagePath;
        }

        if (! empty($request->gamename)) {
            $game = Game::firstOrCreate(
                ['name' => $request->gamename],
                ['created_user_id' => auth()->user()->id]
            );

            $dlc->game_id = $game->id;
        }

        $dlc->save();

        return to_route('dlc', $dlc)->with('message', __('dlc.dlcupdated'));
    }
}
