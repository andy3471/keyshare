<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Issue28AddMissingForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dlcs', function (Blueprint $table) {
            $table->unsignedBigInteger('game_id')->change();
            $table->foreign('game_id')->references('id')->on('games');
        });

        Schema::table('linked_accounts', function (Blueprint $table) {
            $table->unsignedBigInteger('linked_account_provider_id')->change();
            $table->foreign('linked_account_provider_id')->references('id')->on('linked_account_providers');
        });

        Schema::table('subscriptions', function (Blueprint $table) {
            $table->unsignedBigInteger('platform_id')->change();
            $table->foreign('platform_id')->references('id')->on('platforms');
        });

        Schema::table('wallets', function (Blueprint $table) {
            $table->unsignedBigInteger('platform_id')->change();
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
        Schema::table('dlcs', function (Blueprint $table) {
            $table->dropForeign('dlcs_game_id_foreign');
        });
        Schema::table('dlcs', function (Blueprint $table) {
            $table->bigInteger('game_id')->change();
        });


        Schema::table('linked_accounts', function (Blueprint $table) {
            $table->dropForeign('linked_accounts_linked_account_provider_id_foreign');
        });
        Schema::table('linked_accounts', function (Blueprint $table) {
            $table->bigInteger('linked_account_provider_id')->change();
        });


        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropForeign('subscriptions_platform_id_foreign');
        });
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->bigInteger('platform_id')->change();
        });


        Schema::table('wallets', function (Blueprint $table) {
            $table->dropForeign('wallets_platform_id_foreign');
        });
        Schema::table('wallets', function (Blueprint $table) {
            $table->bigInteger('platform_id')->change();
        });
    }
}
