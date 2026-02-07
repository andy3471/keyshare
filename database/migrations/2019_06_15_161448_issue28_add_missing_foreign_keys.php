<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Issue28AddMissingForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Only add foreign keys that don't already exist in base migrations
        // dlcs.game_id, subscriptions.platform_id, and wallets.platform_id already have foreign keys

        Schema::table('linked_accounts', function (Blueprint $table) {
            // This foreign key wasn't in the initial migration due to order
            $table->foreign('linked_account_provider_id')->references('id')->on('linked_account_providers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('linked_accounts', function (Blueprint $table) {
            $table->dropForeign(['linked_account_provider_id']);
        });
    }
}
