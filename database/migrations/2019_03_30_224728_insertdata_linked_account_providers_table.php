<?php

use Illuminate\Database\Migrations\Migration;

class InsertdataLinkedAccountProvidersTable extends Migration
{
    public function up()
    {
        DB::table('linked_account_providers')->insert([
            ['name' => 'Steam'],
        ]);
    }

    public function down()
    {
        DB::table('linked_account_providers')->truncate();
    }
}
