<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditDescriptionLengthGamesTable extends Migration
{
    public function up()
    {
        Schema::table('games', function (Blueprint $table) {
            $table->longText('description')->change();
        });
    }

    public function down()
    {
        Schema::table('games', function (Blueprint $table) {
            $table->string('description')->change();
        });
    }
}
