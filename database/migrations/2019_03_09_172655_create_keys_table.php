<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKeysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('keys', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('game_id')->references('id')->on('games');
            $table->foreignUuid('platform_id');
            $table->string('keycode');
            $table->foreignUuid('claimed_by_user_id')->references('id')->on('users')->nullable();
            $table->foreignUuid('created_by_user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('keys');
    }
}
