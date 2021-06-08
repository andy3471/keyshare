<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKeysTable extends Migration
{
    public function up()
    {
        Schema::create('keys', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->BigInteger('game_id')->references('id')->on('games');
            $table->BigInteger('dlc_id')->nullable();
            $table->BigInteger('platform_id');
            $table->string('keycode');
            $table->biginteger('owned_user_id')->references('id')->on('users')->nullable();
            $table->biginteger('created_user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('keys');
    }
}
