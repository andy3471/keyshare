<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Remove key_type_id from keys table
        Schema::table('keys', function (Blueprint $table) {
            $table->dropForeign(['key_type_id']);
            $table->dropColumn('key_type_id');
        });

        // Drop key_types table
        Schema::dropIfExists('key_types');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Recreate key_types table
        Schema::create('key_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        DB::table('key_types')->insert([
            ['id' => 1, 'name' => 'Games', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'DLC', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'Wallet', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'name' => 'Subscription', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Re-add key_type_id to keys table
        Schema::table('keys', function (Blueprint $table) {
            $table->unsignedBigInteger('key_type_id')->nullable();
            $table->foreign('key_type_id')->references('id')->on('key_types');
        });
    }
};
