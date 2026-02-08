<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\DataTransferObjects\Groups\GroupData;
use App\DataTransferObjects\Groups\GroupMemberData;
use App\Enums\GroupRole;
use App\Http\Requests\Groups\StoreGroupRequest;
use App\Http\Requests\Groups\UpdateGroupRequest;
use App\Models\Group;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class GroupController extends Controller
{
    public function index(Request $request): Response
    {
        $user = auth()->user();

        return Inertia::render('Groups/Index', [
            'myGroups' => fn () => $user->groups()
                ->withCount('members')
                ->with('media')
                ->get()
                ->map(fn (Group $group) => GroupData::fromModel($group, $group->pivot->role)),
            'publicGroups' => fn () => Group::query()
                ->where('is_public', true)
                ->whereDoesntHave('members', fn ($q) => $q->where('user_id', $user->id))
                ->withCount('members')
                ->with('media')
                ->latest()
                ->limit(12)
                ->get()
                ->map(fn (Group $group) => GroupData::fromModel($group)),
        ]);
    }

    public function create(): Response
    {
        $this->authorize('create', Group::class);

        return Inertia::render('Groups/Create');
    }

    public function store(StoreGroupRequest $request): RedirectResponse
    {
        $this->authorize('create', Group::class);

        $group = Group::create([
            'name'        => $request->validated('name'),
            'description' => $request->validated('description'),
            'owner_id'    => auth()->id(),
            'is_public'   => $request->validated('is_public', false),
        ]);

        if ($request->hasFile('avatar')) {
            $group->addMediaFromRequest('avatar')
                ->toMediaCollection('avatar');
        }

        $group->addMember(auth()->user(), GroupRole::Owner);

        session(['active_group_id' => $group->id]);

        return redirect()->route('groups.show', $group)
            ->with('message', 'Group created successfully.');
    }

    public function show(Group $group): Response
    {
        $group->loadMissing('media');
        $group->loadCount('members');
        auth()->user()->loadMissing(['media', 'groups']);

        $this->authorize('view', $group);

        $user = auth()->user();
        $role = $group->memberRole($user);

        return Inertia::render('Groups/Show', [
            'group'   => fn () => GroupData::fromModel($group, $role?->value),
            'members' => fn () => GroupMemberData::collect(
                $group->members()->with('media')->get()->map(fn (User $member) => GroupMemberData::fromPivot($member))
            ),
            'isMember' => fn () => $group->hasMember($user),
        ]);
    }

    public function edit(Group $group): Response
    {
        $group->loadMissing('media');
        auth()->user()->loadMissing(['media', 'groups']);

        $this->authorize('update', $group);

        return Inertia::render('Groups/Edit', [
            'group' => fn () => GroupData::fromModel($group, $group->memberRole(auth()->user())?->value),
        ]);
    }

    public function update(UpdateGroupRequest $request, Group $group): RedirectResponse
    {
        $this->authorize('update', $group);

        $group->update($request->safe()->except(['avatar']));

        if ($request->hasFile('avatar')) {
            $group->addMediaFromRequest('avatar')
                ->toMediaCollection('avatar');
        }

        return redirect()->route('groups.show', $group)
            ->with('message', 'Group updated successfully.');
    }

    public function destroy(Group $group): RedirectResponse
    {
        $this->authorize('delete', $group);

        if (session('active_group_id') === $group->id) {
            session()->forget('active_group_id');
        }

        $group->delete();

        return redirect()->route('groups.index')
            ->with('message', 'Group deleted successfully.');
    }

    public function join(Group $group): RedirectResponse
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

        return redirect()->route('groups.show', $group)
            ->with('message', 'You have joined the group.');
    }

    public function joinViaInviteCode(Request $request, string $code): RedirectResponse
    {
        $group = Group::where('invite_code', $code)->firstOrFail();
        $user  = auth()->user();

        if ($group->hasMember($user)) {
            session(['active_group_id' => $group->id]);

            return redirect()->route('groups.show', $group)
                ->with('message', 'You are already a member of this group.');
        }

        $group->addMember($user);

        session(['active_group_id' => $group->id]);

        return redirect()->route('groups.show', $group)
            ->with('message', 'You have joined the group.');
    }

    public function leave(Group $group): RedirectResponse
    {
        $this->authorize('leave', $group);

        $group->members()->detach(auth()->id());

        if (session('active_group_id') === $group->id) {
            session()->forget('active_group_id');
        }

        return redirect()->route('groups.index')
            ->with('message', 'You have left the group.');
    }

    public function removeMember(Group $group, User $user): RedirectResponse
    {
        $this->authorize('manageMembers', $group);

        if ($group->owner_id === $user->id) {
            return back()->with('error', 'Cannot remove the group owner.');
        }

        $group->members()->detach($user->id);

        return back()->with('message', 'Member removed successfully.');
    }

    public function switchGroup(Request $request): RedirectResponse
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

    public function regenerateInviteCode(Group $group): RedirectResponse
    {
        $this->authorize('update', $group);

        $group->regenerateInviteCode();

        return back()->with('message', 'Invite code regenerated.');
    }
}
