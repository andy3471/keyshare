<?php

use Illuminate\Database\Migrations\Migration;

class InsertTwitchLinkedAccountProviders extends Migration
{
    public function up()
    {
        DB::table('linked_account_providers')->insert([
            ['name' => 'Twitch'],
        ]);
    }

    public function down()
    {
        //
    }
}
