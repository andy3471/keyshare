<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\GroupRole;
use App\Models\Group;
use App\Models\User;

class GroupPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Group $group): bool
    {
        return $group->is_public || $group->hasMember($user);
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Group $group): bool
    {
        $role = $group->memberRole($user);

        return $role === GroupRole::Owner || $role === GroupRole::Admin;
    }

    public function delete(User $user, Group $group): bool
    {
        return $group->owner_id === $user->id;
    }

    public function manageMembers(User $user, Group $group): bool
    {
        $role = $group->memberRole($user);

        return $role === GroupRole::Owner || $role === GroupRole::Admin;
    }

    public function invite(User $user, Group $group): bool
    {
        $role = $group->memberRole($user);

        return $role === GroupRole::Owner || $role === GroupRole::Admin;
    }

    public function leave(User $user, Group $group): bool
    {
        return $group->hasMember($user) && $group->owner_id !== $user->id;
    }
}
