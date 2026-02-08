<?php

declare(strict_types=1);

namespace App\Http\Controllers\Groups;

use App\Http\Controllers\Controller;
use App\Models\Group;
use Illuminate\Http\RedirectResponse;

class JoinGroupController extends Controller
{
    public function __invoke(Group $group): RedirectResponse
    {
        $user = auth()->user();

        if ($group->hasMember($user)) {
            return back()->with('error', 'You are already a member of this group.');
        }

        if (! $group->is_public) {
            return back()->with('error', 'This group is private. You need an invitation to join.');
        }

        $group->addMember($user);

        session(['active_group_id' => $group->id]);

        if (! $user->onboarded_at) {
            return back()->with('message', 'You joined '.$group->name.'!');
        }

        return to_route('groups.show', $group)
            ->with('message', 'You have joined the group.');
    }
}
