<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Group;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/** @extends Factory<Group> */
class GroupFactory extends Factory
{
    protected $model = Group::class;

    public function definition(): array
    {
        $name = fake()->unique()->words(2, true);

        return [
            'name'        => $name,
            'slug'        => Str::slug($name),
            'description' => fake()->sentence(),
            'owner_id'    => User::factory(),
            'is_public'   => fake()->boolean(30),
            'invite_code' => Str::random(12),
        ];
    }

    public function public(): static
    {
        return $this->state(['is_public' => true]);
    }

    public function private(): static
    {
        return $this->state(['is_public' => false]);
    }
}
