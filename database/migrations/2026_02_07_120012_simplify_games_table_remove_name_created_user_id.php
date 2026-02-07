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
        Schema::table('games', function (Blueprint $table) {
            // Remove foreign key first
            $table->dropForeign(['created_user_id']);
            // Remove columns
            $table->dropColumn(['name', 'created_user_id']);
        });
    }

    /** Reverse the migrations. */
    public function down(): void
    {
        Schema::table('games', function (Blueprint $table) {
            $table->string('name')->after('id');
            $table->uuid('created_user_id')->after('igdb_id');
            $table->foreign('created_user_id')->references('id')->on('users');
        });
    }
};
