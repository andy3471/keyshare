<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /** Run the migrations. */
    public function up(): void
    {
        // Remove dlc_id from keys table
        Schema::table('keys', function (Blueprint $table) {
            $table->dropForeign(['dlc_id']);
            $table->dropColumn('dlc_id');
        });

        // Drop dlcs table
        Schema::dropIfExists('dlcs');
    }

    /** Reverse the migrations. */
    public function down(): void
    {
        // Recreate dlcs table
        Schema::create('dlcs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('game_id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('image')->nullable();
            $table->uuid('created_user_id');
            $table->timestamps();

            $table->foreign('game_id')->references('id')->on('games');
            $table->foreign('created_user_id')->references('id')->on('users');
        });

        // Re-add dlc_id to keys table
        Schema::table('keys', function (Blueprint $table) {
            $table->uuid('dlc_id')->nullable();
            $table->foreign('dlc_id')->references('id')->on('dlcs');
        });
    }
};
