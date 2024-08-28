<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory;
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

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function linkedAccounts(): HasMany
    {
        return $this->hasMany(LinkedAccount::class);
    }

    public function claimedKeys(): HasMany
    {
        return $this->hasMany(Key::class, 'owned_user_id');
    }

    public function sharedKeys(): HasMany
    {
        return $this->hasMany(Key::class, 'created_user_id');
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->admin;
    }

    public function karma(): Attribute
    {
        return Attribute::make(
            get: function () {
                $id = $this->id;

                // Attempt to get karma from Redis cache
                $karma = Redis::zscore('karma', $id);

                // If karma is found in Redis, return it
                if ($karma !== false) {
                    return $karma;
                }

                // Calculate karma using Eloquent
                $createdKeysCount = \App\Models\Key::where('created_user_id', $id)->count();
                $ownedKeysCount = \App\Models\Key::where('owned_user_id', $id)->count();

                $karma = $createdKeysCount - $ownedKeysCount;

                // Cache the karma in Redis and return it
                Redis::zadd('karma', $karma, $id);

                return $karma;
            }
        );
    }

    public function karmaColour(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->karma < 0) {
                    return 'badge-danger';
                } elseif ($this->karma < 2) {
                    return 'badge-warning';
                } elseif ($this->karma < 15) {
                    return 'badge-info';
                }

                return 'badge-success';
            }
        );
    }
}
