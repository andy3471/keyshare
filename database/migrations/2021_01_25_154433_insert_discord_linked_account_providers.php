<?php

use Illuminate\Database\Migrations\Migration;

class InsertDiscordLinkedAccountProviders extends Migration
{
    public function up()
    {
        DB::table('linked_account_providers')->insert([
            ['name' => 'Discord'],
        ]);
    }

    public function down()
    {
        //
    }
}
