<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Key;
use App\Notifications\KeyAdded;
use App\Notifications\KeyClaimed;

class KeyNotificationObserver
{
    public function created(Key $key): void
    {
        $group = $key->group;

        if (! $group?->hasDiscordWebhook()) {
            return;
        }

        $group->notify(new KeyAdded($key, $key->createdUser, $key->game));
    }

    public function updated(Key $key): void
    {
        if (! $key->wasChanged('owned_user_id') || $key->owned_user_id === null) {
            return;
        }

        $group = $key->group;

        if (! $group?->hasDiscordWebhook()) {
            return;
        }

        $group->notify(new KeyClaimed($key, $key->claimedUser, $key->game));
    }
}
