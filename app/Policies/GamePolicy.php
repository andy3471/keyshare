<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Game;
use App\Models\User;

class GamePolicy
{
    public function create(User $currentUser): bool
    {
        return true;
    }

    public function view(User $currentUser, Game $game): bool
    {
        return true;
    }

    public function viewAny(User $currentUser): bool
    {
        return true;
    }

    public function edit(User $currentUser, Game $game): bool
    {
        return true;
    }
}
