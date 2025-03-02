<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Key extends Model
{
    use HasUuids;
    use Notifiable;
    use SoftDeletes;

    protected $appends = [
        'image',
        'name',
    ];

    protected $fillable = [
        'game_id',
        'platform_id',
        'keycode',
        'message',
        'created_by_user_id',
    ];

    /**
     * @return BelongsTo<Game, $this>
     */
    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    /**
     * @return BelongsTo<Platform, $this>
     */
    public function platform()
    {
        return $this->belongsTo(Platform::class);
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function claimedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'claimed_by_user_id');
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function createdUser()
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }

    public static function scopeUnclaimed(Builder $query): Builder
    {
        return $query->whereNull('claimed_by_user_id');
    }

    protected function name(): Attribute
    {
        return Attribute::make(get: function () {
            return $this->game->name;
        });
    }

    protected function image(): Attribute
    {
        return Attribute::make(get: function () {
            return $this->game->image;
        });
    }

    public function routeNotificationForDiscord()
    {
        return config('services.discord.channel');
    }
}
