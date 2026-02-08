<?php

declare(strict_types=1);

namespace App\Http\Controllers\Groups;

use App\DataTransferObjects\Groups\GroupData;
use App\DataTransferObjects\Groups\GroupMemberData;
use App\Enums\GroupRole;
use App\Http\Controllers\Controller;
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
        $user   = auth()->user();
        $search = $request->string('search')->toString();

        return Inertia::render('Groups/Index', [
            'myGroups' => fn () => $user->groups()
                ->withCount('members')
                ->with('media')
                ->get()
                ->map(fn (Group $group): GroupData => GroupData::fromModel($group, $group->pivot->role)),
            'publicGroups' => Inertia::scroll(function () use ($user, $search): array|\Illuminate\Contracts\Pagination\CursorPaginator|\Illuminate\Contracts\Pagination\Paginator|\Illuminate\Pagination\AbstractCursorPaginator|\Illuminate\Pagination\AbstractPaginator|\Illuminate\Support\Enumerable|\Spatie\LaravelData\CursorPaginatedDataCollection|\Spatie\LaravelData\DataCollection|\Spatie\LaravelData\PaginatedDataCollection {
                $query = Group::query()
                    ->public()
                    ->whereNotMember($user)
                    ->withCount('members')
                    ->with('media')
                    ->latest();

                if ($search !== '') {
                    $query->where('name', 'like', "%{$search}%");
                }

                return GroupData::collect($query->paginate(12));
            }),
            'search' => $search,
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

        $user = auth()->user();

        $group->addMember($user, GroupRole::Owner);

        session(['active_group_id' => $group->id]);

        // If the user is still onboarding, mark them as complete
        if (! $user->onboarded_at) {
            $user->update(['onboarded_at' => now()]);

            return to_route('games.index')
                ->with('message', 'Welcome to Sparekey! Your group '.$group->name.' is ready.');
        }

        return to_route('groups.show', $group)
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
            'group'   => fn (): GroupData => GroupData::fromModel($group, $role?->value),
            'members' => fn (): array|\Illuminate\Contracts\Pagination\CursorPaginator|\Illuminate\Contracts\Pagination\Paginator|\Illuminate\Pagination\AbstractCursorPaginator|\Illuminate\Pagination\AbstractPaginator|\Illuminate\Support\Enumerable|\Spatie\LaravelData\CursorPaginatedDataCollection|\Spatie\LaravelData\DataCollection|\Spatie\LaravelData\PaginatedDataCollection => GroupMemberData::collect(
                $group->members()->with('media')->get()->map(fn (User $member): GroupMemberData => GroupMemberData::fromPivot($member))
            ),
            'isMember' => fn (): bool => $group->hasMember($user),
        ]);
    }

    public function edit(Group $group): Response
    {
        $group->loadMissing('media');
        auth()->user()->loadMissing(['media', 'groups']);

        $this->authorize('update', $group);

        return Inertia::render('Groups/Edit', [
            'group' => fn (): GroupData => GroupData::fromModel($group, $group->memberRole(auth()->user())?->value),
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

        return to_route('groups.show', $group)
            ->with('message', 'Group updated successfully.');
    }

    public function destroy(Group $group): RedirectResponse
    {
        $this->authorize('delete', $group);

        if (session('active_group_id') === $group->id) {
            session()->forget('active_group_id');
        }

        $group->delete();

        return to_route('groups.index')
            ->with('message', 'Group deleted successfully.');
    }
}
