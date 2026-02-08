<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\ClaimDeniedReason;
use App\Models\Key;
use App\Models\User;

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

        if (! $key->group_id || ! $currentUser->isMemberOf($key->group)) {
            return ClaimDeniedReason::NotInGroup;
        }

        $group = $key->group;

        if ($group->min_karma !== null && $currentUser->karma < $group->min_karma) {
            return ClaimDeniedReason::KarmaTooLow;
        }

        return null;
    }

    public function claim(User $currentUser, Key $key): bool
    {
        return ! $this->claimDeniedReason($currentUser, $key) instanceof ClaimDeniedReason;
    }

    public function feedback(User $currentUser, Key $key): bool
    {
        return $key->owned_user_id === $currentUser->id;
    }
}
