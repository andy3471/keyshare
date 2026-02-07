<?php

declare(strict_types=1);

namespace App\DataTransferObjects;

use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class UserData extends Data
{
    public function __construct(
        public string $id,
        public string $name,
        public ?string $email = null,
        public ?string $image = null,
        public ?string $bio = null,
        public ?int $karma = null,
        public ?string $karma_colour = null,
        public ?bool $admin = null,
        public ?bool $approved = null,
    ) {}

    public static function fromModel(\App\Models\User $user): self
    {
        return new self(
            id: (string) $user->id,
            name: $user->name,
            email: $user->email,
            image: $user->image               ?? null,
            bio: $user->bio                   ?? null,
            karma: $user->karma !== null ? (int) $user->karma : null,
            karma_colour: $user->karma_colour ?? 'badge-info',
            admin: $user->admin ?? false,
            approved: $user->approved ?? false,
        );
    }
}
