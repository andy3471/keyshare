<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Key;
use App\Models\User;

class KeyPolicy
{
    public function create(User $user): bool
    {
        return true;
    }

    public function view(User $user, Key $key): bool
    {
        return true;
    }

    public function claim(User $user, Key $key): bool
    {
        return ! $key->claimedUser()->exists();
    }
}
