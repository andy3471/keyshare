<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProfileUrlLinkedAccountsTable extends Migration
{
    public function up()
    {
        Schema::table('linked_accounts', function (Blueprint $table) {
            $table->string('profileurl')->nullable();
        });
    }

    public function down()
    {
        Schema::table('linked_accounts', function (Blueprint $table) {
            $table->dropColumn('profileurl');
        });
    }
}
