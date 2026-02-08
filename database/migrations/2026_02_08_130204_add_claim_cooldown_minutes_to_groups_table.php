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
        Schema::table('groups', function (Blueprint $table) {
            $table->unsignedInteger('claim_cooldown_minutes')->nullable()->after('min_karma');
        });
    }

    public function down(): void
    {
        Schema::table('groups', function (Blueprint $table) {
            $table->dropColumn('claim_cooldown_minutes');
        });
    }
};
