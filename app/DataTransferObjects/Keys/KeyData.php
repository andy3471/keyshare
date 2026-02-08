<?php

declare(strict_types=1);

namespace App\DataTransferObjects\Keys;

use App\DataTransferObjects\Games\GameData;
use App\DataTransferObjects\Groups\GroupData;
use App\DataTransferObjects\Platforms\PlatformData;
use App\DataTransferObjects\Users\UserData;
use App\Enums\KeyFeedback;
use App\Models\Key;
use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class KeyData extends Data
{
    public function __construct(
        public string $id,
        public ?string $key = null,
        public ?string $message = null,
        public ?KeyFeedback $feedback = null,
        public ?PlatformData $platform = null,
        public ?UserData $createdUser = null,
        public ?UserData $claimedUser = null,
        public ?GameData $game = null,
        public ?KeyCanData $can = null,
        public ?GroupData $group = null,
    ) {}

    public static function fromModel(Key $key): self
    {
        return new self(
            id: (string) $key->id,
            key: $key->owned_user_id === auth()->id() ? $key->key : null,
            message: $key->message                 ?? null,
            feedback: ($key->owned_user_id === auth()->id() || $key->created_user_id === auth()->id()) ? $key->feedback : null,
            platform: $key->relationLoaded('platform')       && $key->platform ? PlatformData::fromModel($key->platform) : null,
            createdUser: $key->relationLoaded('createdUser') && $key->createdUser ? UserData::fromModel($key->createdUser) : null,
            claimedUser: $key->relationLoaded('claimedUser') && $key->claimedUser ? UserData::fromModel($key->claimedUser) : null,
            game: $key->relationLoaded('game')               && $key->game ? GameData::fromModel($key->game) : null,
            can: KeyCanData::fromModel($key),
            group: $key->relationLoaded('group') && $key->group ? GroupData::fromModel($key->group) : null,
        );
    }
}
