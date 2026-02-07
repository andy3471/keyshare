<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Game;
use App\Models\Key;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\Discord\DiscordChannel;
use NotificationChannels\Discord\DiscordMessage;

class KeyAdded extends Notification
{
    use Queueable;

    public string $url;

    public function __construct(
        public Key $key,
        public User $user,
        public Game $game
    ) {
        // TODO: Use route helper. Move to DiscordMessage rather than construct
        $this->url = config('app.url').'/keys/'.$key->id;
    }

    public function via($notifiable): array
    {
        return [DiscordChannel::class];
    }

    public function toDiscord($notifiable)
    {
        return DiscordMessage::create("A key for {$this->game->name} on {$this->key->platform->name} has been added by {$this->user->name}. Claim it at {$this->url}.");
    }

    public function toArray($notifiable): array
    {
        return [
            //
        ];
    }
}
