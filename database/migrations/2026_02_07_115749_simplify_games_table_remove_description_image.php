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
            $table->dropColumn(['description', 'image', 'igdb_updated']);
        });
    }

    /** Reverse the migrations. */
    public function down(): void
    {
        Schema::table('games', function (Blueprint $table) {
            $table->string('description')->nullable()->after('name');
            $table->string('image')->nullable()->after('created_user_id');
            $table->date('igdb_updated')->nullable()->after('igdb_id');
        });
    }
};
