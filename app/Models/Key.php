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
        // TODO: use constants
        return Attribute::make(
            get: function () {
                if ($this->key_type_id == 1) {
                    return $this->game->name;
                } elseif ($this->key_type_id == 2) {
                    return "{$this->game->name}: {$this->dlc->name}";
                }
            }
        );
    }

    public function image(): Attribute
    {
        // TODO: use constants
        return Attribute::make(
            get: function () {
                if ($this->key_type_id == 1) {
                    return $this->game->image;
                } elseif ($this->key_type_id == 2) {
                    return $this->dlc->image;
                }
            }
        );
    }

    public function getUrlAttribute(): Attribute
    {
        // TODO: Use route helper
        return Attribute::make(
            get: function () {
                return "/keys/{$this->id}";
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
