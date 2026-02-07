<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PopulatePlatformsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $now = now();
        DB::table('platforms')->insert([
            // Digital distribution platforms
            ['id' => Str::uuid(), 'name' => 'Steam', 'igdb_id' => null, 'created_at' => $now, 'updated_at' => $now],
            ['id' => Str::uuid(), 'name' => 'Origin', 'igdb_id' => null, 'created_at' => $now, 'updated_at' => $now],
            ['id' => Str::uuid(), 'name' => 'Uplay', 'igdb_id' => null, 'created_at' => $now, 'updated_at' => $now],
            ['id' => Str::uuid(), 'name' => 'Epic Games', 'igdb_id' => null, 'created_at' => $now, 'updated_at' => $now],
            ['id' => Str::uuid(), 'name' => 'GOG', 'igdb_id' => null, 'created_at' => $now, 'updated_at' => $now],
            ['id' => Str::uuid(), 'name' => 'Windows Store', 'igdb_id' => null, 'created_at' => $now, 'updated_at' => $now],
            ['id' => Str::uuid(), 'name' => 'Battle.net', 'igdb_id' => null, 'created_at' => $now, 'updated_at' => $now],
            // Modern consoles that support digital keys
            ['id' => Str::uuid(), 'name' => 'PlayStation 4', 'igdb_id' => null, 'created_at' => $now, 'updated_at' => $now],
            ['id' => Str::uuid(), 'name' => 'PlayStation 5', 'igdb_id' => null, 'created_at' => $now, 'updated_at' => $now],
            ['id' => Str::uuid(), 'name' => 'Xbox One', 'igdb_id' => null, 'created_at' => $now, 'updated_at' => $now],
            ['id' => Str::uuid(), 'name' => 'Xbox Series X|S', 'igdb_id' => null, 'created_at' => $now, 'updated_at' => $now],
            ['id' => Str::uuid(), 'name' => 'Nintendo Switch', 'igdb_id' => null, 'created_at' => $now, 'updated_at' => $now],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('platforms')->truncate();
    }
}
