<?php

use Illuminate\Database\Migrations\Migration;

class PopulatePlatformsTable extends Migration
{
    public array $platforms = [
        ['name' => 'Steam'],
        ['name' => 'Ubisoft Connect'],
        ['name' => 'EA App'],
        ['name' => 'Windows Store'],
        ['name' => 'Blizzard'],
        ['name' => 'GOG'],
        ['name' => 'PS4'],
        ['name' => 'PS5'],
        ['name' => 'PS Vita'],
        ['name' => 'Switch'],
        ['name' => 'Xbox'],
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach ($this->platforms as $idx => $platform) {
            $this->platforms[$idx]['id'] = Str::orderedUuid()->toString();
            $this->platforms[$idx]['created_at'] = now();
            $this->platforms[$idx]['updated_at'] = now();
        }

        DB::table('platforms')->insert($this->platforms);
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
