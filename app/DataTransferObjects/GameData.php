<?php

declare(strict_types=1);

namespace App\DataTransferObjects;

use App\Models\Game;
use MarcReichel\IGDBLaravel\Models\Game as IgdbGame;
use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class GameData extends Data
{
    public function __construct(
        public string $id,
        public string $name,
        public ?string $description = null,
        public ?string $image = null,
        public ?string $url = null,
    ) {}

    public static function fromModel(Game $game): self
    {
        return new self(
            id: (string) $game->igdb_id,
            name: $game->name,
            description: $game->description ?? null,
            image: $game->image             ?? null,
        );
    }

    public static function fromIgdb(IgdbGame $igdbGame): self
    {
        $image = null;

        if ($igdbGame->cover && isset($igdbGame->cover->image_id)) {
            $image = 'https://images.igdb.com/igdb/image/upload/t_cover_big/'.$igdbGame->cover->image_id.'.jpg';
        }

        return new self(
            id: $igdbGame->id,
            name: $igdbGame->name           ?? 'Unknown',
            description: $igdbGame->summary ?? null,
            image: $image,
        );
    }
}
