<?php

namespace App\Resources;

use App\Models\Game;
use Spatie\LaravelData\Resource;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class GameResource extends Resource
{
    public function __construct(
        public string $name,
        public string $description,
        // TODO: Image
    ) {}

    public static function fromModel(Game $game): static
    {
        return new static(
            name: $game->name,
            description: $game->description
        );
    }
}
