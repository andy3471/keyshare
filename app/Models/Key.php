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

    /**
     * @return BelongsTo<Game, $this>
     */
    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    /**
     * @return BelongsTo<Dlc, $this>
     */
    public function dlc(): BelongsTo
    {
        // TODO: Migrate to polymorphic relationship
        return $this->belongsTo(Dlc::class);
    }

    /**
     * @return BelongsTo<KeyType, $this>
     */
    public function keyType(): BelongsTo
    {
        return $this->belongsTo(KeyType::class);
    }

    /**
     * @return BelongsTo<Platform, $this>
     */
    public function platform(): BelongsTo
    {
        return $this->belongsTo(Platform::class);
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function claimedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owned_user_id');
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function createdUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_user_id');
    }

    public function routeNotificationForDiscord(): string
    {
        return config('services.discord.channel');
    }

    protected function name(): Attribute
    {
        return Attribute::make(
            get: function () {
                // Access the relationship properly - check if loaded, otherwise load it
                if ($this->relationLoaded('keyType')) {
                    $keyType = $this->relations['keyType'];
                } elseif ($this->key_type_id) {
                    $keyType = $this->keyType()->first();
                } else {
                    return null;
                }
                
                // If keyType is not a model instance (e.g., it's the ID), return null
                if (!($keyType instanceof KeyType)) {
                    return null;
                }
                
                $keyTypeName = $keyType->name;
                
                if ($keyTypeName === 'Games') {
                    return $this->game?->name;
                }
                if ($keyTypeName === 'DLC') {
                    return ($this->dlc?->name ?? '').': '.($this->game?->name ?? '');
                }
                
                return null;
            }
        );
    }

    protected function image(): Attribute
    {
        return Attribute::make(
            get: function () {
                // Access the relationship properly - check if loaded, otherwise load it
                if ($this->relationLoaded('keyType')) {
                    $keyType = $this->relations['keyType'];
                } elseif ($this->key_type_id) {
                    $keyType = $this->keyType()->first();
                } else {
                    return null;
                }
                
                // If keyType is not a model instance (e.g., it's the ID), return null
                if (!($keyType instanceof KeyType)) {
                    return null;
                }
                
                $keyTypeName = $keyType->name;
                
                if ($keyTypeName === 'Games') {
                    return $this->game?->image;
                }
                if ($keyTypeName === 'DLC') {
                    return $this->dlc?->image;
                }
                
                return null;
            }
        );
    }

    protected function url(): Attribute
    {
        return Attribute::make(
            get: function (): string {
                return route('keys.show', $this->id);
            }
        );
    }
}
