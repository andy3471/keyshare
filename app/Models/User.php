<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\GroupRole;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Redis;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class User extends Authenticatable implements FilamentUser, HasMedia
{
    use HasFactory;
    use HasUuids;
    use InteractsWithMedia;
    use Notifiable;

    protected $appends = [
        'karma',
        'karma_colour',
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

    /** @return BelongsToMany<Group, $this> */
    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class)
            ->withPivot('role', 'joined_at');
    }

    /** @return HasMany<Group, $this> */
    public function ownedGroups(): HasMany
    {
        return $this->hasMany(Group::class, 'owner_id');
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->is_admin;
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('avatar')
            ->useFallbackUrl('/images/defaultpic.jpg')
            ->singleFile();
    }

    public function isMemberOf(Group $group): bool
    {
        return $this->groups()->where('group_id', $group->id)->exists();
    }

    public function roleIn(Group $group): ?GroupRole
    {
        $pivot = $this->groups()->where('group_id', $group->id)->first()?->pivot;

        return $pivot ? GroupRole::from($pivot->role) : null;
    }

    /** @return Attribute<string, never> */
    protected function avatar(): Attribute
    {
        return Attribute::make(
            get: function (): string {
                return $this->getFirstMediaUrl('avatar');
            }
        );
    }

    /** @return Attribute<int, int> */
    protected function karma(): Attribute
    {
        return Attribute::make(
            get: function () {
                $id    = (string) $this->id;
                $karma = Redis::zscore('karma', $id);

                if ($karma !== false) {
                    return $karma;
                }

                $createdKeysCount = Key::where('created_user_id', $id)->count();
                $ownedKeysCount   = Key::where('owned_user_id', $id)->count();

                $karma = $createdKeysCount - $ownedKeysCount;

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
            'is_admin'          => 'boolean',
        ];
    }
}
