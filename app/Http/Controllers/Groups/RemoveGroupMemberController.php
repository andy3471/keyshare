<?php

declare(strict_types=1);

namespace App\Http\Controllers\Groups;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\User;
use Illuminate\Http\RedirectResponse;

class RemoveGroupMemberController extends Controller
{
    public function __invoke(Group $group, User $user): RedirectResponse
    {
        $this->authorize('manageMembers', $group);

        if ($group->owner_id === $user->id) {
            return back()->with('error', 'Cannot remove the group owner.');
        }

        $group->members()->detach($user->id);

        return back()->with('message', 'Member removed successfully.');
    }
}
