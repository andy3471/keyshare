<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateGameImages extends Migration
{
    public function up()
    {
        Schema::table('games', function (Blueprint $table) {
            $table->string('image')->default('/images/gamedefault.png')->change();

            DB::update("UPDATE games
                SET image = CONCAT('/', image) 
                WHERE image NOT LIKE 'https://%'
            ");
        });
    }

    public function down()
    {
        Schema::table('games', function (Blueprint $table) {
            $table->string('image')->default('images/gamedefault.png')->change();
        });
    }
}
