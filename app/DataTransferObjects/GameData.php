<?php

declare(strict_types=1);

namespace App\DataTransferObjects;

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
        public ?int $igdb_id = null,
    ) {}

    public static function fromModel(\App\Models\Game $game): self
    {
        return new self(
            id: (string) $game->id,
            name: $game->name,
            description: $game->description ?? null,
            image: $game->image             ?? null,
            url: $game->url                 ?? null,
            igdb_id: $game->igdb_id         ?? null,
        );
    }

    /**
     * Create GameData from IGDB game model
     * Optionally checks if a Game model exists in our database and uses that ID
     */
    public static function fromIgdb(\MarcReichel\IGDBLaravel\Models\Game $igdbGame, ?\App\Models\Game $gameModel = null): self
    {
        // Use existing Game model ID if provided, otherwise use IGDB ID as string
        $id = $gameModel ? (string) $gameModel->id : (string) $igdbGame->id;
        
        // Generate image URL from IGDB cover
        $image = null;
        if ($igdbGame->cover && isset($igdbGame->cover->image_id)) {
            $image = 'https://images.igdb.com/igdb/image/upload/t_cover_big/'.$igdbGame->cover->image_id.'.jpg';
        }
        
        // Generate URL using IGDB ID
        $url = route('games.show', $igdbGame->id);
        
        return new self(
            id: $id,
            name: $igdbGame->name ?? 'Unknown',
            description: $igdbGame->summary ?? null,
            image: $image,
            url: $url,
            igdb_id: $igdbGame->id,
        );
    }
}
