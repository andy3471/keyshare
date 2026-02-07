<?php

declare(strict_types=1);

namespace App\DataTransferObjects\Users;

use App\Models\User;
use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class UserProfileData extends Data
{
    public function __construct(
        public UserData $user,
    ) {}

    public static function fromModel(User $user): self
    {
        return new self(
            user: UserData::fromModel($user),
        );
    }
}
