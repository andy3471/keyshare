<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function create(User $currentUser): bool
    {
        return true;
    }

    public function view(User $currentUser, User $user): bool
    {
        return true;
    }

    public function edit(User $currentUser, User $user): bool
    {
        return $currentUser->id === $user->id;
    }
}
