<?php

declare(strict_types=1);

namespace App\DataTransferObjects\Groups;

use App\Models\User;
use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class GroupMemberData extends Data
{
    public function __construct(
        public string $id,
        public string $name,
        public ?string $avatar = null,
        public string $role = 'member',
        public ?string $joined_at = null,
    ) {}

    public static function fromPivot(User $user): self
    {
        return new self(
            id: (string) $user->id,
            name: $user->name,
            avatar: $user->avatar              ?? null,
            role: $user->pivot->role           ?? 'member',
            joined_at: $user->pivot->joined_at ?? null,
        );
    }
}
