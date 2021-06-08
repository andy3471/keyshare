<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMessageColumnKeysTable extends Migration
{
    public function up()
    {
        Schema::table('keys', function (Blueprint $table) {
            $table->string('message',500)->nullable();
        });
    }

    public function down()
    {
        Schema::table('keys', function (Blueprint $table) {
            $table->dropColumn('message');
        });
    }
}
