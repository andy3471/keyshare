<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeletedFieldKeysTable extends Migration
{
    public function up()
    {
        Schema::table('keys', function (Blueprint $table) {
            $table->boolean('removed')->default('0');
        });

        DB::update("UPDATE `keys`
                    SET removed = '0'
                    WHERE removed is null
                    ");
    }

    public function down()
    {
        Schema::table('keys', function (Blueprint $table) {
            $table->dropColumn('removed');
        });
    }
}
