<?php

declare(strict_types=1);

namespace App\Http\Controllers\Groups;

use App\Http\Controllers\Controller;
use App\Models\Group;
use Illuminate\Http\RedirectResponse;

class AcceptGroupInviteController extends Controller
{
    public function __invoke(string $code): RedirectResponse
    {
        $group = Group::where('invite_code', $code)->firstOrFail();
        $user  = auth()->user();

        if ($group->hasMember($user)) {
            session(['active_group_id' => $group->id]);

            return to_route('groups.show', $group)
                ->with('message', 'You are already a member of this group.');
        }

        $group->addMember($user);

        session(['active_group_id' => $group->id]);

        return to_route('groups.show', $group)
            ->with('message', 'You have joined the group.');
    }
}
