<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('keys', function (Blueprint $table): void {
            $table->foreignUuid('group_id')->nullable()->after('id')->constrained()->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('keys', function (Blueprint $table): void {
            $table->dropConstrainedForeignId('group_id');
        });
    }
};
