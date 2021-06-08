<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSetupRequiredColumnUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('setup_required')->default('0');
        });

        DB::update("UPDATE users
            SET setup_required = '1'
            WHERE email NOT LIKE '%@%'
        ");
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('setup_required');
        });
    }
}
