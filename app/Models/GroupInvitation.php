<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class GroupInvitation extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'group_id',
        'email',
        'token',
        'invited_by',
        'accepted_at',
        'expires_at',
    ];

    /** @return BelongsTo<Group, $this> */
    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    /** @return BelongsTo<User, $this> */
    public function inviter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'invited_by');
    }

    public function isExpired(): bool
    {
        return $this->expires_at !== null && $this->expires_at->isPast();
    }

    public function isAccepted(): bool
    {
        return $this->accepted_at !== null;
    }

    public function isPending(): bool
    {
        return ! $this->isAccepted() && ! $this->isExpired();
    }

    protected static function booted(): void
    {
        static::creating(function (GroupInvitation $invitation): void {
            if (! $invitation->token) {
                $invitation->token = Str::random(64);
            }
        });
    }

    protected function casts(): array
    {
        return [
            'accepted_at' => 'datetime',
            'expires_at'  => 'datetime',
        ];
    }
}
