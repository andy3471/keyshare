<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Platform;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubscriptionFactory extends Factory
{
    protected $model = Subscription::class;

    public function definition(): array
    {
        return [
            'platform_id'     => Platform::all()->random()->id,
            'name'            => fake()->unique()->realText(10),
            'description'     => fake()->paragraph($nbSentences = 1),
            'created_user_id' => User::all()->random()->id,
        ];
    }
}
