<?php

namespace Database\Factories;

use App\Models\Game;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class GameFactory extends Factory
{
    protected $model = Game::class;

    public function definition(): array
    {
        if (config('igdb.enabled')) {
            $igdb = IGDB::select(['name', 'summary', 'id'])
                ->with(['cover' => ['image_id']])
                ->orderBy('first_release_date', 'desc')
                ->whereNotNull('summary')
                ->whereNotNull('cover')
                ->where('aggregated_rating', '>=', 70)
                ->skip(rand(1, 1000))
                ->first();

            return [
                'name' => $igdb->name,
                'description' => $igdb->summary,
                'igdb_id' => $igdb->id,
                'image' => 'https://images.igdb.com/igdb/image/upload/t_cover_big/'.$igdb->cover->image_id.'.jpg',
                'igdb_updated' => Carbon::today(),
                'created_user_id' => User::all()->random()->id,
            ];
        } else {
            return [
                'name' => fake()->unique()->realText(20),
                'description' => fake()->paragraph($nbSentences = 1),
                'created_user_id' => User::all()->random()->id,
            ];
        }
    }
}
