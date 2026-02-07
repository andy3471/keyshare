<?php

declare(strict_types=1);

namespace App\DataTransferObjects;

use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class KeyData extends Data
{
    public function __construct(
        public int $id,
        public ?int $game_id = null,
        public ?int $dlc_id = null,
        public int $platform_id = 0,
        public ?string $keycode = null,
        public ?string $message = null,
        public ?int $created_user_id = null,
        public ?int $owned_user_id = null,
        public ?string $name = null,
        public ?string $image = null,
        public ?string $url = null,
        public ?PlatformData $platform = null,
        public ?UserData $createdUser = null,
        public ?UserData $claimedUser = null,
        public ?GameData $game = null,
        public ?DlcData $dlc = null,
    ) {}

    public static function fromModel(\App\Models\Key $key): self
    {
        return new self(
            id: $key->id,
            game_id: $key->game_id ?? null,
            dlc_id: $key->dlc_id   ?? null,
            platform_id: $key->platform_id,
            keycode: $key->keycode                 ?? null,
            message: $key->message                 ?? null,
            created_user_id: $key->created_user_id ?? null,
            owned_user_id: $key->owned_user_id     ?? null,
            name: $key->name                       ?? null,
            image: $key->image                     ?? null,
            url: $key->url                         ?? null,
            platform: $key->relationLoaded('platform')       && $key->platform ? PlatformData::fromModel($key->platform) : null,
            createdUser: $key->relationLoaded('createdUser') && $key->createdUser ? UserData::fromModel($key->createdUser) : null,
            claimedUser: $key->relationLoaded('claimedUser') && $key->claimedUser ? UserData::fromModel($key->claimedUser) : null,
            game: $key->relationLoaded('game')               && $key->game ? GameData::fromModel($key->game) : null,
            dlc: $key->relationLoaded('dlc')                 && $key->dlc ? DlcData::fromModel($key->dlc) : null,
        );
    }
}
