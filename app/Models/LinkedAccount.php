<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\LinkedAccountProvider;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LinkedAccount extends Model
{
    use HasUuids;

    protected $fillable = [
        'user_id',
        'provider',
        'provider_user_id',
        'data',
    ];

    /** @return BelongsTo<User, $this> */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /** @param Builder<self> $query */
    #[\Illuminate\Database\Eloquent\Attributes\Scope]
    protected function forProvider(Builder $query, LinkedAccountProvider $provider): void
    {
        $query->where('provider', $provider);
    }

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'provider' => LinkedAccountProvider::class,
            'data'     => 'array',
        ];
    }
}
