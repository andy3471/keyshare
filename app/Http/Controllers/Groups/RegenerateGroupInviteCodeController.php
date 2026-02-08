<?php

declare(strict_types=1);

namespace App\Http\Controllers\Groups;

use App\Http\Controllers\Controller;
use App\Models\Group;
use Illuminate\Http\RedirectResponse;

class RegenerateGroupInviteCodeController extends Controller
{
    public function __invoke(Group $group): RedirectResponse
    {
        $this->authorize('update', $group);

        $group->regenerateInviteCode();

        return back()->with('message', 'Invite code regenerated.');
    }
}
