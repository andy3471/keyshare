<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;

class Key extends Model
{
    use HasFactory;
    use HasUuids;
    use Notifiable;

    protected $fillable = [
        'game_id',
        'platform_id',
        'key',
        'message',
        'created_user_id',
    ];

    /** @return BelongsTo<Game, $this> */
    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    /** @return BelongsTo<Platform, $this> */
    public function platform(): BelongsTo
    {
        return $this->belongsTo(Platform::class);
    }

    /** @return BelongsTo<User, $this> */
    public function claimedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owned_user_id');
    }

    /** @return BelongsTo<User, $this> */
    public function createdUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_user_id');
    }

    public function routeNotificationForDiscord(): string
    {
        return config('services.discord.channel');
    }
}
