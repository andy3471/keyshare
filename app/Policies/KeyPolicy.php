<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\ClaimDeniedReason;
use App\Enums\KeyFeedback;
use App\Models\Key;
use App\Models\User;
use Carbon\CarbonInterface;

class KeyPolicy
{
    public function create(User $currentUser): bool
    {
        return $currentUser->groups()->exists();
    }

    public function view(User $currentUser, Key $key): bool
    {
        if ($currentUser->id === $key->created_user_id) {
            return true;
        }

        if (! $key->group_id) {
            return false;
        }

        return $currentUser->isMemberOf($key->group);
    }

    public function claimDeniedReason(User $currentUser, Key $key): ?ClaimDeniedReason
    {
        if ($key->owned_user_id !== null) {
            return ClaimDeniedReason::AlreadyClaimed;
        }

        if ($key->created_user_id === $currentUser->id) {
            return ClaimDeniedReason::OwnKey;
        }

        if ($key->game_id !== null && $key->platform_id !== null) {
            $alreadyOwns = Key::query()
                ->where('game_id', $key->game_id)
                ->where('platform_id', $key->platform_id)
                ->where('owned_user_id', $currentUser->id)
                ->where(fn ($query) => $query->whereNull('feedback')->orWhere('feedback', '!=', KeyFeedback::DidNotWork))
                ->exists();

            if ($alreadyOwns) {
                return ClaimDeniedReason::AlreadyOwnsGame;
            }
        }

        if (! $key->group_id || ! $currentUser->isMemberOf($key->group)) {
            return ClaimDeniedReason::NotInGroup;
        }

        $group = $key->group;

        if ($group->min_karma !== null && $currentUser->karma < $group->min_karma) {
            return ClaimDeniedReason::KarmaTooLow;
        }

        if ($group->claim_cooldown_minutes !== null && $this->cooldownEndsAt($currentUser, $group)?->isFuture()) {
            return ClaimDeniedReason::CooldownActive;
        }

        return null;
    }

    public function claim(User $currentUser, Key $key): bool
    {
        return ! $this->claimDeniedReason($currentUser, $key) instanceof ClaimDeniedReason;
    }

    public function cooldownEndsAt(User $currentUser, \App\Models\Group $group): ?CarbonInterface
    {
        if ($group->claim_cooldown_minutes === null) {
            return null;
        }

        $lastClaimedAt = Key::query()
            ->where('group_id', $group->id)
            ->where('owned_user_id', $currentUser->id)
            ->latest('updated_at')
            ->value('updated_at');

        if (! $lastClaimedAt) {
            return null;
        }

        $endsAt = \Illuminate\Support\Facades\Date::parse($lastClaimedAt)
            ->addMinutes($group->claim_cooldown_minutes);

        return $endsAt->isFuture() ? $endsAt : null;
    }

    public function delete(User $currentUser, Key $key): bool
    {
        return $key->created_user_id === $currentUser->id && $key->owned_user_id === null;
    }

    public function feedback(User $currentUser, Key $key): bool
    {
        return $key->owned_user_id === $currentUser->id;
    }
}
