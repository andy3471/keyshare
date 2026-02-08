<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\DataTransferObjects\Groups\GroupData;
use App\DataTransferObjects\Users\UserData;
use App\Models\Group;
use Closure;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Symfony\Component\HttpFoundation\Response;

class HandleInertiaRequests extends Middleware
{
    protected $rootView = 'app';

    public function handle(Request $request, Closure $next): Response
    {
        auth()->user()?->loadMissing(['media', 'groups']);

        return parent::handle($request, $next);
    }

    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /** @return array<string, mixed> */
    public function share(Request $request): array
    {
        $user = auth()->user();

        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $user ? UserData::from($user) : null,
            ],
            'flash' => [
                'message' => $request->session()->get('message'),
                'error'   => $request->session()->get('error'),
            ],
            'activeGroup'  => fn () => $this->getActiveGroup($request),
            'userGroups'   => fn () => $user
                ? $user->groups()->withCount('members')->with('media')->get()->map(fn (Group $group) => GroupData::fromModel($group, $group->pivot->role))
                : [],
        ]);
    }

    private function getActiveGroup(Request $request): ?GroupData
    {
        $user = auth()->user();

        if (! $user) {
            return null;
        }

        $groupId = $request->session()->get('active_group_id');

        if (! $groupId) {
            return null;
        }

        $group = Group::with('media')->find($groupId);

        if (! $group || ! $group->hasMember($user)) {
            $request->session()->forget('active_group_id');

            return null;
        }

        return GroupData::fromModel($group, $group->memberRole($user)?->value);
    }
}
