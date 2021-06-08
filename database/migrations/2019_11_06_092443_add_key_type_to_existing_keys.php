<?php

use Illuminate\Database\Migrations\Migration;

class AddKeyTypeToExistingKeys extends Migration
{
    public function up()
    {
	DB::update("UPDATE `keys`
		SET key_type_id = '1'
		WHERE key_type_id is null
	");
    }

    public function down()
    {
    }
}
