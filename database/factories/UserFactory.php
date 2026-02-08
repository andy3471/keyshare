<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'name'              => fake()->name,
            'email'             => fake()->unique()->safeEmail,
            'email_verified_at' => now(),
            'password'          => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token'    => Str::random(10),
            'bio'               => fake()->paragraph($nbSentences = 1),
            'is_admin'          => false,
            'onboarded_at'      => now(),
        ];
    }

    /** Create a user that still needs to complete onboarding. */
    public function needsOnboarding(): static
    {
        return $this->state(fn (): array => [
            'email'        => 'social_'.Str::random(16).'@placeholder.local',
            'onboarded_at' => null,
        ]);
    }
}
