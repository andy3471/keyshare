<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateDlcDefaultImage extends Migration
{
    public function up()
    {
        Schema::table('dlcs', function (Blueprint $table) {
            $table->string('image')->default('/images/gamedefault.png')->change();

            DB::update("UPDATE dlcs
                SET image = CONCAT('/', image) 
                WHERE image NOT LIKE 'https://%'
            ");
        });
    }

    public function down()
    {
        Schema::table('dlcs', function (Blueprint $table) {
            $table->string('image')->default('images/gamedefault.png')->change();
        });
    }
}
