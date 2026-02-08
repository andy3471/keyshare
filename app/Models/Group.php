<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\GroupRole;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Group extends Model implements HasMedia
{
    use HasFactory;
    use HasUuids;
    use InteractsWithMedia;
    use Notifiable;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'owner_id',
        'is_public',
        'invite_code',
        'discord_webhook_url',
        'min_karma',
    ];

    /** @return BelongsTo<User, $this> */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /** @return BelongsToMany<User, $this> */
    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->withPivot('role', 'joined_at');
    }

    /** @return HasMany<Key, $this> */
    public function keys(): HasMany
    {
        return $this->hasMany(Key::class);
    }

    /** @return HasMany<GroupInvitation, $this> */
    public function invitations(): HasMany
    {
        return $this->hasMany(GroupInvitation::class);
    }

    public function hasMember(User $user): bool
    {
        if ($user->relationLoaded('groups')) {
            return $user->groups->contains('id', $this->id);
        }

        return $this->members()->where('user_id', $user->id)->exists();
    }

    public function memberRole(User $user): ?GroupRole
    {
        if ($user->relationLoaded('groups')) {
            $group = $user->groups->firstWhere('id', $this->id);

            return $group ? GroupRole::from($group->pivot->role) : null;
        }

        $pivot = $this->members()->where('user_id', $user->id)->first()?->pivot;

        return $pivot ? GroupRole::from($pivot->role) : null;
    }

    public function addMember(User $user, GroupRole $role = GroupRole::Member): void
    {
        $this->members()->attach($user->id, [
            'id'        => Str::uuid()->toString(),
            'role'      => $role->value,
            'joined_at' => now(),
        ]);
    }

    public function regenerateInviteCode(): void
    {
        $this->update(['invite_code' => Str::random(12)]);
    }

    public function hasDiscordWebhook(): bool
    {
        return ! empty($this->discord_webhook_url);
    }

    public function routeNotificationForDiscordWebhook(): ?string
    {
        return $this->discord_webhook_url;
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('avatar')
            ->singleFile();
    }

    protected static function booted(): void
    {
        static::creating(function (Group $group): void {
            if (! $group->slug) {
                $group->slug = Str::slug($group->name);
            }

            if (! $group->invite_code) {
                $group->invite_code = Str::random(12);
            }
        });
    }

    /** @param \Illuminate\Database\Eloquent\Builder<self> $query */
    #[\Illuminate\Database\Eloquent\Attributes\Scope]
    protected function public(\Illuminate\Database\Eloquent\Builder $query): void
    {
        $query->where('is_public', true);
    }

    /** @param \Illuminate\Database\Eloquent\Builder<self> $query */
    #[\Illuminate\Database\Eloquent\Attributes\Scope]
    protected function whereNotMember(\Illuminate\Database\Eloquent\Builder $query, User $user): void
    {
        $query->whereDoesntHave('members', fn ($q) => $q->where('user_id', $user->id));
    }

    /** @return Attribute<string|null, never> */
    protected function avatarUrl(): Attribute
    {
        return Attribute::make(
            get: fn (): ?string => $this->getFirstMediaUrl('avatar') ?: null,
        );
    }

    protected function casts(): array
    {
        return [
            'is_public' => 'boolean',
            'min_karma' => 'integer',
        ];
    }
}
