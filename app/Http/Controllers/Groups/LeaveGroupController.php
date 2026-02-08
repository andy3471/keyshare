<?php

declare(strict_types=1);

namespace App\Http\Controllers\Groups;

use App\Http\Controllers\Controller;
use App\Models\Group;
use Illuminate\Http\RedirectResponse;

class LeaveGroupController extends Controller
{
    public function __invoke(Group $group): RedirectResponse
    {
        $this->authorize('leave', $group);

        $group->members()->detach(auth()->id());

        if (session('active_group_id') === $group->id) {
            session()->forget('active_group_id');
        }

        return to_route('groups.index')
            ->with('message', 'You have left the group.');
    }
}
