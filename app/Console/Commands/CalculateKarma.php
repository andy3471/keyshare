<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CalculateKarma extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:CalculateKarma';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Recalculate Karma';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //Old Query (Per User)
        // SELECT (IFNULL(C.createdkeys,0) - IFNULL(O.ownedkeys,0)) AS karma FROM users AS U
        // LEFT OUTER JOIN (
        //         SELECT COUNT(created_user_id) AS createdkeys, created_user_id AS user_id FROM `keys`
        //         WHERE removed IS NULL
        //         AND created_user_id = $user_id
        //         GROUP BY created_user_id
        //     ) AS C
        // ON C.user_id = U.user_id
        // LEFT OUTER JOIN (
        //         SELECT count(owned_user) AS ownedkeys, owned_user AS user_id FROM `keys`
        //         WHERE removed IS NULL
        //     AND owned_user = $user_id
        //         GROUP BY owned_user
        //     ) AS O
        // ON O.user_id = U.user_id
        // WHERE U.approved = 1
        // AND U.user_id = $user_id
        // LIMIT 1
    }
}
