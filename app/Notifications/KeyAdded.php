<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\Discord\DiscordChannel;
use NotificationChannels\Discord\DiscordMessage;

class KeyAdded extends Notification
{
    public $key;

    public $game;

    public $user;

    /**
     * @var string
     */
    public $url;

    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($key, $user, $game)
    {
        $this->key = $key;
        $this->game = $game;
        $this->user = $user;

        $this->url = config('app.url').'/keys/'.$key->id;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     */
    public function via($notifiable): array
    {
        return [DiscordChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toDiscord($notifiable)
    {
        return DiscordMessage::create("A key for {$this->game->name} on {$this->key->platform->name} has been added by {$this->user->name}. Claim it at {$this->url}.");
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     */
    public function toArray($notifiable): array
    {
        return [
            //
        ];
    }
}
