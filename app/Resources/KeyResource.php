<?php

namespace App\Resources;

use App\Filament\SuperAdmin\Resources\UserResource;
use App\Models\Key;
use Spatie\LaravelData\Lazy;
use Spatie\LaravelData\Optional;
use Spatie\LaravelData\Resource;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class KeyResource extends Resource
{
    public function __construct(
        public Lazy|GameResource $game,
        public Lazy|PlatformResource $platform,
        public Lazy|null|UserResource $created_by_user,
        public Lazy|null|UserResource $claimed_by_user,
        public Optional|string $keycode,

    ) {}

    public static function fromModel(Key $key): static
    {
        return new static(
            game: Lazy::model($key->game, GameResource::class),
            platform: Lazy::model($key->platform, PlatformResource::class),
            created_by_user: Lazy::model($key->created_by_user, UserResource::class),
            claimed_by_user: Lazy::model($key->claimed_by_user, UserResource::class),
            keycode: Optional::nullable($key->keycode),
        );
    }
}
