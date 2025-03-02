<?php

namespace App\Resources;

use App\Models\User;
use Spatie\LaravelData\Resource;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class UserResource extends Resource
{
    public function __construct(
        public string $name,
        public string $bio,
        // TODO: Image
    ) {}

    public static function fromModel(User $user): static
    {
        return new static(
            name: $user->name,
            bio: $user->bio
        );
    }
}
