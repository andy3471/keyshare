<?php

declare(strict_types=1);

namespace App\DataTransferObjects;

use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class DlcData extends Data
{
    public function __construct(
        public int $id,
        public string $name,
        public ?string $description = null,
        public ?string $image = null,
        public ?int $game_id = null,
        public ?GameData $game = null,
    ) {}

    public static function fromModel(\App\Models\Dlc $dlc): self
    {
        return new self(
            id: $dlc->id,
            name: $dlc->name,
            description: $dlc->description ?? null,
            image: $dlc->image             ?? null,
            game_id: $dlc->game_id         ?? null,
            game: $dlc->relationLoaded('game') && $dlc->game ? GameData::fromModel($dlc->game) : null,
        );
    }
}
