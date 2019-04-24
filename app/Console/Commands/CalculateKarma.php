<?php

namespace App\Console\Commands;
use Illuminate\Support\Facades\DB;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;
class CalculateKarma extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'karma:calculate';

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
        $karma = DB::select(DB::raw('
            SELECT (IFNULL(C.createdkeys,0) - IFNULL(O.ownedkeys,0)) AS karma, U.id FROM homestead.users AS U
            LEFT OUTER JOIN (
                SELECT COUNT(created_user_id) AS createdkeys, created_user_id AS user_id FROM homestead.`keys`
                GROUP BY created_user_id
            ) AS C
            ON C.user_id = U.id
            LEFT OUTER JOIN (
                SELECT count(owned_user_id) AS ownedkeys, owned_user_id AS user_id FROM homestead.`keys`
                GROUP BY owned_user_id
            ) AS O
            ON O.user_id = U.id'
        ));

        Redis::del('karma');

        foreach ($karma as $user) {
            $this->info('UserID:' . $user->id . '   Karma:' . $user->karma);
            Redis::zadd('karma', $user->karma, $user->id);
        }

    }
}
