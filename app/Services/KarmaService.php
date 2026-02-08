<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\KeyFeedback;
use App\Models\Key;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class KarmaService
{
    private const CACHE_PREFIX = 'karma:user:';

    private const CACHE_TTL_SECONDS = 86400;

    public static function colour(int $karma): string
    {
        if ($karma < 0) {
            return 'badge-danger';
        }

        if ($karma < 2) {
            return 'badge-warning';
        }

        if ($karma < 15) {
            return 'badge-info';
        }

        return 'badge-success';
    }

    public function getKarma(User $user): int
    {
        return (int) Cache::remember(
            self::CACHE_PREFIX.$user->id,
            self::CACHE_TTL_SECONDS,
            fn (): int => $this->calculateKarma($user)
        );
    }

    public function incrementKarma(User $user): void
    {
        if (Cache::has(self::CACHE_PREFIX.$user->id)) {
            Cache::increment(self::CACHE_PREFIX.$user->id);
        } else {
            Cache::put(self::CACHE_PREFIX.$user->id, $this->calculateKarma($user), self::CACHE_TTL_SECONDS);
        }
    }

    public function decrementKarma(User $user): void
    {
        if (Cache::has(self::CACHE_PREFIX.$user->id)) {
            Cache::decrement(self::CACHE_PREFIX.$user->id);
        } else {
            Cache::put(self::CACHE_PREFIX.$user->id, $this->calculateKarma($user), self::CACHE_TTL_SECONDS);
        }
    }

    public function recalculateKarma(User $user): int
    {
        $karma = $this->calculateKarma($user);

        Cache::put(self::CACHE_PREFIX.$user->id, $karma, self::CACHE_TTL_SECONDS);

        return $karma;
    }

    public function recalculateAll(): void
    {
        User::query()->each(function (User $user): void {
            $this->recalculateKarma($user);
        });
    }

    private function calculateKarma(User $user): int
    {
        $earned = Key::query()
            ->where('created_user_id', $user->id)
            ->whereNotNull('owned_user_id')
            ->where(function ($query): void {
                $query->whereNull('feedback')
                    ->orWhere('feedback', '!=', KeyFeedback::DidNotWork);
            })
            ->count();

        $spent = Key::query()
            ->where('owned_user_id', $user->id)
            ->count();

        return $earned - $spent;
    }
}
