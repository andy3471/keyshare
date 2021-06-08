<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWalletsTable extends Migration
{
    public function up()
    {
        Schema::create('wallets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->BigInteger('platform_id')->references('id')->on('platforms');
            $table->BigInteger('value');
            $table->string('description')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
            $table->BigInteger('created_user_id')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::dropIfExists('wallets');
    }
}
