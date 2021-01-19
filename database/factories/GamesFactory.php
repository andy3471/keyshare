<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Game;
use Faker\Generator as Faker;
use App\User;
use MarcReichel\IGDBLaravel\Models\Game as Igdb;
use Carbon\Carbon;

$factory->define(Game::class, function (Faker $faker) {
    if(config('igdb.enabled')) {
        $igdb = Igdb::select(['name', 'summary', 'id'])
            ->with(['cover' => ['image_id']])
            ->orderBy('first_release_date', 'desc')
            ->whereNotNull('summary')
            ->whereNotNull('cover')
            ->where('aggregated_rating', '>=', 70)
            ->skip(rand(1,1000))
            ->first();

        return [
            'name'              =>  $igdb->name,
            'description'       =>  $igdb->summary,
            'igdb_id'           =>  $igdb->id,
            'image'             => 'https://images.igdb.com/igdb/image/upload/t_cover_big/' . $igdb->cover->image_id . '.jpg',
            'igdb_updated'      =>  Carbon::today(),
            'created_user_id'   =>  User::all()->random()->id,
        ];
    } else {
        return [
            'name'              =>  $faker->unique()->realText(20),
            'description'       =>  $faker->paragraph($nbSentences = 1),
            'created_user_id'   =>  User::all()->random()->id,
        ];
    }

});
