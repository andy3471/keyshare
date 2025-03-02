<?php

namespace App\Models;

use App\Services\KarmaService;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class User extends Authenticatable implements HasMedia
{
    use HasUuids;
    use InteractsWithMedia;
    use Notifiable;

    protected $appends = [
        'karma',
        'karma_color',
    ];

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @return HasMany<LinkedAccount, $this>
     */
    public function linkedAccounts(): HasMany
    {
        return $this->hasMany(LinkedAccount::class);
    }

    /**
     * @return HasMany<Key, $this>
     */
    public function claimedKeys(): HasMany
    {
        return $this->hasMany(Key::class, 'claimed_by_user_id');
    }

    /**
     * @return HasMany<Key, $this>
     */
    public function sharedKeys(): HasMany
    {
        return $this->hasMany(Key::class, 'created_by_user_id');
    }

    /**
     * @return BelongsToMany<Group, $this>
     */
    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class);
    }

    protected function karma(): Attribute
    {
        return Attribute::make(get: function (): int {
            return KarmaService::get($this);
        });
    }

    protected function karmaColor(): Attribute
    {
        return Attribute::make(get: function (): string {
            return KarmaService::getColor($this);
        });
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'is_super_admin' => 'boolean',
        ];
    }
}
