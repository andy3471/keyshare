<?php

declare(strict_types=1);

namespace App\Http\Controllers\Groups;

use App\Http\Controllers\Controller;
use App\Models\Group;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SwitchGroupController extends Controller
{
    public function __invoke(Request $request): RedirectResponse
    {
        $groupId = $request->input('group_id');

        if ($groupId) {
            $group = Group::findOrFail($groupId);
            abort_unless($group->hasMember(auth()->user()), 403);
            session(['active_group_id' => $group->id]);
        } else {
            session()->forget('active_group_id');
        }

        return back();
    }
}
