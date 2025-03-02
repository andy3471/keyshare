<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Redis;

class KarmaService
{
    public static function get(User $user): int
    {
        $karma = Redis::zscore('karma', $user->id);

        if ($karma) {
            return $karma;
        }

        $claimedCount = $user->claimed_keys_count;
        $sharedCount = $user->shared_keys_count;

        $karma = $sharedCount - $claimedCount;

        Redis::zadd('karma', $karma, $user->id);

        return $karma;
    }

    public static function getColor(User $user): string
    {
        $karma = self::get($user);

        if ($karma > 0) {
            return 'text-success';
        }

        if ($karma < 0) {
            return 'text-danger';
        }

        return 'text-muted';
    }

    public static function increment(User $user, int $amount = 1): void
    {
        Redis::zincrby('karma', $amount, $user->id);
    }

    public static function decrement(User $user, int $amount = 1): void
    {
        Redis::zincrby('karma', -$amount, $user->id);
    }
}
