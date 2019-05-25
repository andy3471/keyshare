<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDeletedFieldKeysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
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

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('keys', function (Blueprint $table) {
            $table->dropColumn('removed');
        });
    }
}
