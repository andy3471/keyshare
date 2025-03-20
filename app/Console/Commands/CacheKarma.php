<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class CacheKarma extends Command
{
    protected $signature = 'cache:karma';

    protected $description = 'Cache All Users Karma';

    public function handle(): void
    {
        $karmaData = User::withCount([
            'createdKeys as createdkeys' => fn ($query) => $query->selectRaw('COUNT(*)'),
            'ownedKeys as ownedkeys' => fn ($query) => $query->selectRaw('COUNT(*)'),
        ])
            ->get()
            ->map(fn ($user) => [
                'id' => $user->id,
                'karma' => ($user->createdkeys ?? 0) - ($user->ownedkeys ?? 0),
            ]);

        Redis::del('karma');

        foreach ($karmaData as $user) {
            $this->info("UserID: {$user['id']}   Karma: {$user['karma']}");
            Redis::zadd('karma', $user['karma'], $user['id']);
        }
    }
}
