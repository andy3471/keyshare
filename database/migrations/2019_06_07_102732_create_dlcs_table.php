<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDlcsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dlcs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->BigInteger('game_id')->references('id')->on('games');
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
            $table->BigInteger('created_user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dlcs');
    }
}
