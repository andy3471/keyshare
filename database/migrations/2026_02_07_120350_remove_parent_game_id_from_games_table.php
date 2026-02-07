<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('games', function (Blueprint $table) {
            // Remove foreign key first
            $table->dropForeign(['parent_game_id']);
            // Remove column
            $table->dropColumn('parent_game_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('games', function (Blueprint $table) {
            $table->uuid('parent_game_id')->nullable()->after('igdb_id');
            $table->foreign('parent_game_id')->references('id')->on('games')->onDelete('cascade');
        });
    }
};
