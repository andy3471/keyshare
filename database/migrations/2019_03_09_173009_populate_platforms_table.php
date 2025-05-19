<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;

class PopulatePlatformsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('platforms')->insert([
            ['name' => 'Steam'],
            ['name' => 'Uplay'],
            ['name' => 'Origin'],
            ['name' => 'Windows Store'],
            ['name' => 'Blizzard'],
            ['name' => 'GOG'],
            ['name' => 'PS3'],
            ['name' => 'PS4'],
            ['name' => 'PS Vita'],
            ['name' => 'Switch'],
            ['name' => 'Xbox 360'],
            ['name' => 'Xbox One'],
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
