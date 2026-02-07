<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Game;
use App\Models\Group;
use App\Models\Key;
use App\Models\User;
use App\Notifications\Channels\DiscordWebhookChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class KeyClaimed extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Key $key,
        public User $claimedBy,
        public Game $game
    ) {}

    /** @return array<int, class-string> */
    public function via(Group $notifiable): array
    {
        return [DiscordWebhookChannel::class];
    }

    /** @return array<string, string> */
    public function toDiscordWebhook(Group $notifiable): array
    {
        $url = route('games.show', ['igdb_id' => $this->game->igdb_id]);

        return [
            'content' => "🎉 **{$this->claimedBy->name}** claimed a key for **{$this->game->name}** on {$this->key->platform->name}! [View Game]({$url})",
        ];
    }
}
