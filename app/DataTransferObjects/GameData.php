<?php

declare(strict_types=1);

namespace App\DataTransferObjects;

use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class GameData extends Data
{
    public function __construct(
        public int $id,
        public string $name,
        public ?string $description = null,
        public ?string $image = null,
        public ?string $url = null,
        public ?int $igdb_id = null,
    ) {}

    public static function fromModel(\App\Models\Game $game): self
    {
        return new self(
            id: $game->id,
            name: $game->name,
            description: $game->description ?? null,
            image: $game->image             ?? null,
            url: $game->url                 ?? null,
            igdb_id: $game->igdb_id         ?? null,
        );
    }
}
