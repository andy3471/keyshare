<?php

declare(strict_types=1);

namespace App\Http\Controllers\Onboarding;

use App\Enums\OnboardingStep;
use App\Http\Controllers\Controller;
use App\Models\Group;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ShowOnboardingGroupController extends Controller
{
    public function __invoke(Request $request): Response|RedirectResponse
    {
        $user = $request->user();

        if ($user->onboardingStep() === OnboardingStep::Complete) {
            return to_route('games.index');
        }

        if ($user->onboardingStep() === OnboardingStep::SetCredentials) {
            return to_route('onboarding.credentials');
        }

        // If there's a pending invite, auto-join and complete onboarding
        if (($redirect = $this->tryJoinPendingInvite($user)) instanceof RedirectResponse) {
            return $redirect;
        }

        $publicGroups = Group::query()
            ->public()
            ->whereNotMember($user)
            ->withCount('members')
            ->with('media')
            ->orderByDesc('members_count')
            ->limit(12)
            ->get()
            ->map(fn (Group $group): array => [
                'id'           => $group->id,
                'name'         => $group->name,
                'slug'         => $group->slug,
                'description'  => $group->description,
                'member_count' => $group->members_count,
                'avatar'       => $group->avatar_url,
            ]);

        return Inertia::render('Onboarding/JoinGroup', [
            'publicGroups'     => $publicGroups,
            'joinedGroupCount' => $user->groups()->count(),
        ]);
    }

    /** If there's a pending invite code in session, join that group and mark onboarding complete. */
    private function tryJoinPendingInvite(\App\Models\User $user): ?RedirectResponse
    {
        $code = session()->pull('pending_invite_code');

        if (! $code) {
            return null;
        }

        $group = Group::where('invite_code', $code)->first();

        if (! $group) {
            return null;
        }

        if (! $group->hasMember($user)) {
            $group->addMember($user);
        }

        session(['active_group_id' => $group->id]);
        $user->update(['onboarded_at' => now()]);

        return to_route('groups.show', $group)
            ->with('message', 'Welcome to Sparekey! You joined '.$group->name.'.');
    }
}
