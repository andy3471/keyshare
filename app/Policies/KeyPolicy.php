<?php

declare(strict_types=1);

namespace App\Policies;

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
        if (! $key->group_id) {
            return false;
        }

        return $currentUser->isMemberOf($key->group);
    }

    public function claim(User $currentUser, Key $key): bool
    {
        if ($key->claimedUser()->exists()) {
            return false;
        }

        if (! $key->group_id) {
            return false;
        }

        return $currentUser->isMemberOf($key->group);
    }
}
