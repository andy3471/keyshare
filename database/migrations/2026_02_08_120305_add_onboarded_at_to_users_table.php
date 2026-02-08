<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->timestamp('onboarded_at')->nullable()->after('remember_token');
        });

        // Backfill existing users so they skip onboarding
        DB::table('users')->whereNull('onboarded_at')->update([
            'onboarded_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->dropColumn('onboarded_at');
        });
    }
};
