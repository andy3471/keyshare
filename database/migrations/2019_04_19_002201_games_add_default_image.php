<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class GamesAddDefaultImage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('games', function (Blueprint $table) {
            $table->string('image')->default('images/gamedefault.png')->change();

        DB::update("UPDATE games
                    SET image = 'images/gamedefault.png'
                    WHERE image is null
                    ");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('games', function (Blueprint $table) {
            $table->string('image')->nullable()->change();

        DB::update("UPDATE games
                    SET image = null
                    WHERE image = 'images/gamedefault.png'
                    ");
        });
    }
}
