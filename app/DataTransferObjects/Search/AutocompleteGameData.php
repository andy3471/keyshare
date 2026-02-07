<?php

declare(strict_types=1);

namespace App\DataTransferObjects\Search;

use MarcReichel\IGDBLaravel\Models\Game as IgdbGame;
use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class AutocompleteGameData extends Data
{
    public function __construct(
        public string $id,
        public string $name,
    ) {}

    public static function fromIgdb(IgdbGame $igdbGame): self
    {
        return new self(
            id: (string) $igdbGame->id,
            name: $igdbGame->name ?? 'Unknown',
        );
    }

    public static function fromIgdbId(int $igdbId): ?self
    {
        $igdbGame = IgdbGame::select(['name', 'id'])
            ->where('id', '=', $igdbId)
            ->first();

        if (! $igdbGame) {
            return null;
        }

        return self::fromIgdb($igdbGame);
    }
}
