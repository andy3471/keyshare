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
        Schema::table('keys', function (Blueprint $table) {
            $table->dropForeign('keys_wallet_id_foreign');
            $table->dropColumn('wallet_id');
            $table->dropForeign('keys_subscription_id_foreign');
            $table->dropColumn('subscription_id');
            $table->dropColumn('removed');
        });

        Schema::dropIfExists('subscriptions');
        Schema::dropIfExists('wallets');

        Schema::table('platforms', function (Blueprint $table) {
            $table->dropColumn('igdb_id');
        });
    }

    /** Reverse the migrations. */
    public function down(): void
    {
        Schema::create('wallets', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('platform_id');
            $table->BigInteger('value');
            $table->string('description')->nullable();
            $table->string('image')->nullable();
            $table->uuid('created_user_id');
            $table->timestamps();

            $table->foreign('platform_id')->references('id')->on('platforms');
            $table->foreign('created_user_id')->references('id')->on('users');
        });

        Schema::create('subscriptions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('platform_id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('image')->nullable();
            $table->uuid('created_user_id');
            $table->timestamps();

            $table->foreign('platform_id')->references('id')->on('platforms');
            $table->foreign('created_user_id')->references('id')->on('users');
        });

        Schema::table('keys', function (Blueprint $table) {
            $table->uuid('wallet_id')->nullable();
            $table->uuid('subscription_id')->nullable();
            $table->boolean('removed')->default(false);
        });

        Schema::table('platforms', function (Blueprint $table) {
            $table->integer('igdb_id')->nullable();
        });
    }
};
