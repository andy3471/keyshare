<?php

namespace App\Policies;

use App\Models\Key;
use App\Models\User;

class KeyPolicy
{
    public function create(User $user)
    {
        return true;
    }

    public function view(User $user, Key $key)
    {
        return true;
    }

    public function claim(User $user, Key $key)
    {
        if (!$key->claimedUser()->exists()) {
            return true;
        }

        return false;
    }
}
