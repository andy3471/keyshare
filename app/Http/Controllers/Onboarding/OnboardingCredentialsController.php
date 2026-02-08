<?php

declare(strict_types=1);

namespace App\Http\Controllers\Onboarding;

use App\Enums\OnboardingStep;
use App\Http\Controllers\Controller;
use App\Models\Group;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;
use Inertia\Response;

class OnboardingCredentialsController extends Controller
{
    public function create(Request $request): Response|RedirectResponse
    {
        $user = $request->user();

        if ($user->onboardingStep() !== OnboardingStep::SetCredentials) {
            return $this->redirectToCurrentStep($user);
        }

        return Inertia::render('Onboarding/SetCredentials', [
            'name'         => $user->name,
            'pendingGroup' => $this->pendingGroup(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $user = $request->user();

        abort_unless($user->onboardingStep() === OnboardingStep::SetCredentials, 403);

        $validated = $request->validate([
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'password' => ['required', 'string', Password::defaults(), 'confirmed'],
        ]);

        $user->update([
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // If there's a pending invite, auto-join and skip the group step
        if (($redirect = $this->tryJoinPendingInvite($user)) instanceof RedirectResponse) {
            return $redirect;
        }

        return to_route('onboarding.group');
    }

    /**
     * Load the pending invite group info for the banner.
     *
     * @return array{name: string, avatar: string|null}|null
     */
    private function pendingGroup(): ?array
    {
        $code = session('pending_invite_code');

        if (! $code) {
            return null;
        }

        $group = Group::where('invite_code', $code)->first();

        if (! $group) {
            return null;
        }

        $group->loadMissing('media');

        return [
            'name'   => $group->name,
            'avatar' => $group->avatar_url,
        ];
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

    private function redirectToCurrentStep(\App\Models\User $user): RedirectResponse
    {
        $step = $user->onboardingStep();

        if ($step->isComplete()) {
            return to_route('games.index');
        }

        return to_route($step->routeName());
    }
}
