<?php

declare(strict_types=1);

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Redis;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory;
    use HasUuids;
    use Notifiable;

    protected $appends = [
        'karma',
        'karma_colour',
    ];

    protected $fillable = [
        'name',
        'email',
        'password',
        'approved',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /** @return HasMany<LinkedAccount, $this> */
    public function linkedAccounts(): HasMany
    {
        return $this->hasMany(LinkedAccount::class);
    }

    /** @return HasMany<Key, $this> */
    public function claimedKeys(): HasMany
    {
        return $this->hasMany(Key::class, 'owned_user_id');
    }

    /** @return HasMany<Key, $this> */
    public function sharedKeys(): HasMany
    {
        return $this->hasMany(Key::class, 'created_user_id');
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return (bool) $this->admin;
    }

    /** @return Attribute<int, int> */
    protected function karma(): Attribute
    {
        return Attribute::make(
            get: function () {
                $id = (string) $this->id;

                // Attempt to get karma from Redis cache
                $karma = Redis::zscore('karma', $id);

                // If karma is found in Redis, return it
                if ($karma !== false) {
                    return $karma;
                }

                // Calculate karma using Eloquent
                $createdKeysCount = Key::where('created_user_id', $id)->count();
                $ownedKeysCount   = Key::where('owned_user_id', $id)->count();

                $karma = $createdKeysCount - $ownedKeysCount;

                // Cache the karma in Redis and return it
                Redis::zadd('karma', $karma, $id);

                return $karma;
            }
        );
    }

    /** @return Attribute<string, string> */
    protected function karmaColour(): Attribute
    {
        return Attribute::make(
            get: function (): string {
                if ($this->karma < 0) {
                    return 'badge-danger';
                }

                if ($this->karma < 2) {
                    return 'badge-warning';
                }

                if ($this->karma < 15) {
                    return 'badge-info';
                }

                return 'badge-success';
            }
        );
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'admin'             => 'boolean',
            'approved'          => 'boolean',
        ];
    }
}
