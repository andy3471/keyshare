<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddingKeytypesKeysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('keys', function (Blueprint $table) {
            // Add new columns
            $table->unsignedBigInteger('key_type_id')->nullable();
            $table->uuid('wallet_id')->nullable();
            $table->uuid('subscription_id')->nullable();

            // Add foreign keys for new columns and columns that weren't in initial migration
            $table->foreign('key_type_id')->references('id')->on('key_types');
            $table->foreign('wallet_id')->references('id')->on('wallets');
            $table->foreign('subscription_id')->references('id')->on('subscriptions');
            $table->foreign('dlc_id')->references('id')->on('dlcs');
            $table->foreign('platform_id')->references('id')->on('platforms');
            // Note: game_id foreign key already exists from create_keys_table migration
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('keys', function (Blueprint $table) {
            // Drop foreign keys added in this migration
            $table->dropForeign(['key_type_id']);
            $table->dropForeign(['wallet_id']);
            $table->dropForeign(['subscription_id']);
            $table->dropForeign(['dlc_id']);
            
            // Drop columns added in this migration
            $table->dropColumn(['key_type_id', 'wallet_id', 'subscription_id']);
        });
    }
}
