<?php

declare(strict_types=1);

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
            $table->uuid('game_id')->nullable();
            $table->uuid('dlc_id')->nullable();
            $table->uuid('platform_id');
            $table->string('keycode');
            $table->uuid('owned_user_id')->nullable();
            $table->uuid('created_user_id');
            $table->timestamps();
            
            // Foreign keys for tables that exist at this point
            $table->foreign('game_id')->references('id')->on('games');
            $table->foreign('owned_user_id')->references('id')->on('users');
            $table->foreign('created_user_id')->references('id')->on('users');
            // Note: platform_id and dlc_id foreign keys are added later in adding_keytypes_keys_table migration
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
