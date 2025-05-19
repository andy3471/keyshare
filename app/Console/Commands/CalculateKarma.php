<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class CalculateKarma extends Command
{
    protected $signature = 'karma:calculate';

    protected $description = 'Recalculate Karma';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(): void
    {
        // TODO: Tidy code duplication

        $karma = DB::select('
            SELECT (COALESCE(C.createdkeys, 0) - COALESCE(O.ownedkeys, 0)) AS karma, U.id FROM users AS U
            LEFT OUTER JOIN (
                SELECT COUNT(created_user_id) AS createdkeys, created_user_id AS user_id FROM `keys`
                GROUP BY created_user_id
            ) AS C
            ON C.user_id = U.id
            LEFT OUTER JOIN (
                SELECT count(owned_user_id) AS ownedkeys, owned_user_id AS user_id FROM `keys`
                GROUP BY owned_user_id
            ) AS O
            ON O.user_id = U.id
        ');

        Redis::del('karma');

        foreach ($karma as $user) {
            $this->info('UserID:'.$user->id.'   Karma:'.$user->karma);
            Redis::zadd('karma', $user->karma, $user->id);
        }

    }
}
