<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Group;
use App\Models\GroupInvitation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/** @extends Factory<GroupInvitation> */
class GroupInvitationFactory extends Factory
{
    protected $model = GroupInvitation::class;

    public function definition(): array
    {
        return [
            'group_id'   => Group::factory(),
            'email'      => fake()->unique()->safeEmail(),
            'token'      => Str::random(64),
            'invited_by' => User::factory(),
            'expires_at' => now()->addDays(7),
        ];
    }

    public function accepted(): static
    {
        return $this->state(['accepted_at' => now()]);
    }

    public function expired(): static
    {
        return $this->state(['expires_at' => now()->subDay()]);
    }
}
