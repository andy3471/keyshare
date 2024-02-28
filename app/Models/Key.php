<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;

class Key extends Model
{
    use HasFactory;
    use Notifiable;

    protected $appends = [
        'url',
        'image',
        'name',
    ];

    protected $fillable = [
        'game_id',
        'platform_id',
        'keycode',
        'message',
        'created_user_id',
    ];

    public function name(): Attribute
    {
        return Attribute::make(
            get: function () {
                switch ($this->key_type_id) {
                    case KeyType::GAME:
                        return $this->game->name;
                    case KeyType::DLC:
                        return $this->dlc->name.': '.$this->game->name;
                }
            }
        );
    }

    public function image(): Attribute
    {
        return Attribute::make(
            get: function () {
                switch ($this->key_type_id) {
                    case KeyType::GAME:
                        return $this->game->image;
                    case KeyType::DLC:
                        return $this->dlc->image;
                }
            }
        );
    }

    public function url(): Attribute
    {
        return Attribute::make(
            get: function () {
                return route('keys.show', $this->id);
            }
        );
    }

    public function game(): BelongsTo
    {
        // TODO: Migrate to polymorphic relationship
        return $this->belongsTo(Game::class);
    }

    public function dlc(): BelongsTo
    {
        // TODO: Migrate to polymorphic relationship
        return $this->belongsTo(Dlc::class);
    }

    public function keyType(): BelongsTo
    {
        return $this->belongsTo(KeyType::class);
    }

    public function platform(): BelongsTo
    {
        return $this->belongsTo(Platform::class);
    }

    public function claimedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owned_user_id');
    }

    public function createdUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_user_id');
    }

    public function routeNotificationForDiscord(): string
    {
        return config('services.discord.channel');
    }
}
