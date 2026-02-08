<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('keys', function (Blueprint $table) {
            $table->string('feedback')->nullable()->after('owned_user_id');
        });
    }

    public function down(): void
    {
        Schema::table('keys', function (Blueprint $table) {
            $table->dropColumn('feedback');
        });
    }
};
