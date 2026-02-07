<?php

declare(strict_types=1);

namespace App\DataTransferObjects\Keys;

use App\DataTransferObjects\Games\GameData;
use App\DataTransferObjects\Platforms\PlatformData;
use App\DataTransferObjects\Users\UserData;
use App\Models\Key;
use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class KeyData extends Data
{
    public function __construct(
        public string $id,
        public ?string $game_id = null,
        public string $platform_id = '',
        public ?string $key = null,
        public ?string $message = null,
        public ?string $created_user_id = null,
        public ?string $owned_user_id = null,
        public ?string $name = null,
        public ?string $image = null,
        public ?PlatformData $platform = null,
        public ?UserData $createdUser = null,
        public ?UserData $claimedUser = null,
        public ?GameData $game = null,
    ) {}

    public static function fromModel(Key $key): self
    {
        return new self(
            id: (string) $key->id,
            game_id: $key->game_id ? (string) $key->game_id : null,
            platform_id: (string) $key->platform_id,
            key: $key->key                         ?? null,
            message: $key->message                 ?? null,
            created_user_id: $key->created_user_id ? (string) $key->created_user_id : null,
            owned_user_id: $key->owned_user_id ? (string) $key->owned_user_id : null,
            name: $key->name                       ?? null,
            image: $key->image                     ?? null,
            platform: $key->relationLoaded('platform')       && $key->platform ? PlatformData::fromModel($key->platform) : null,
            createdUser: $key->relationLoaded('createdUser') && $key->createdUser ? UserData::fromModel($key->createdUser) : null,
            claimedUser: $key->relationLoaded('claimedUser') && $key->claimedUser ? UserData::fromModel($key->claimedUser) : null,
            game: $key->relationLoaded('game')               && $key->game ? GameData::fromModel($key->game) : null,
        );
    }
}
