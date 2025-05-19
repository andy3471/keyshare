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
            $table->unsignedBigInteger('key_type_id')->nullable();
            $table->unsignedBigInteger('wallet_id')->nullable();
            $table->unsignedBigInteger('subscription_id')->nullable();

            $table->unsignedBigInteger('game_id')->nullable()->change();
            $table->unsignedBigInteger('dlc_id')->nullable()->change();
            $table->unsignedBigInteger('platform_id')->change();

            $table->foreign('key_type_id')->references('id')->on('key_types');
            $table->foreign('wallet_id')->references('id')->on('wallets');
            $table->foreign('subscription_id')->references('id')->on('subscriptions');
            $table->foreign('dlc_id')->references('id')->on('dlcs');
            $table->foreign('game_id')->references('id')->on('games');
            $table->foreign('platform_id')->references('id')->on('platforms');

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
            $table->dropForeign('keys_key_type_id_foreign');
            $table->dropForeign('keys_wallet_id_foreign');
            $table->dropForeign('keys_subscription_id_foreign');
            $table->dropForeign('keys_dlc_id_foreign');
            $table->dropForeign('keys_game_id_foreign');
            $table->dropForeign('keys_platform_id_foreign');
        });

        Schema::table('keys', function (Blueprint $table) {
            $table->bigInteger('game_id')->nullable($value = false)->change();
            $table->bigInteger('dlc_id')->nullable()->change();
            $table->bigInteger('platform_id')->change();
            $table->dropColumn(['key_type_id', 'wallet_id', 'subscription_id']);
        });
    }
}
