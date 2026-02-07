<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DlcAddDefaultImage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dlcs', function (Blueprint $table) {
            $table->string('image')->default('images/dlcdefault.png')->change();

            DB::update("UPDATE dlcs
                    SET image = 'images/dlcdefault.png'
                    WHERE image is null
                    ");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dlcs', function (Blueprint $table) {
            $table->string('image')->nullable()->change();

            DB::update("UPDATE dlcs
                    SET image = null
                    WHERE image = 'images/dlcdefault.png'
                    ");
        });
    }
}
