<?php

use App\Models\Key;
use Illuminate\Database\Migrations\Migration;

class AddKeyTypeToExistingKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Key::where('key_type_id', null)->update(['key_type_id' => 1]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {}
}
