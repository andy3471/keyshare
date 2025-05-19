<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;

class InsertdataLinkedAccountProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('linked_account_providers')->insert([
            ['name' => 'Steam'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('linked_account_providers')->truncate();
    }
}
