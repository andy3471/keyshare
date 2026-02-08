<?php

declare(strict_types=1);

namespace App\DataTransferObjects\Games;

use App\Models\Game;
use App\Models\Key;
use MarcReichel\IGDBLaravel\Models\Game as IgdbGame;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Lazy;
use Spatie\LaravelData\Optional;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class GameData extends Data
{
    /**
     * @param  GenreData[]|Optional|Lazy  $genres
     * @param  ScreenshotData[]|Optional|Lazy  $screenshots
     */
    public function __construct(
        public string $id,
        public string $name,
        public Optional|Lazy|array $genres = new Optional(),
        public Optional|Lazy|array $screenshots = new Optional(),
        public Optional|Lazy|int $aggregated_rating = new Optional(),
        public Optional|Lazy|int $aggregated_rating_count = new Optional(),
        public ?string $description = null,
        public ?string $image = null,
        public int|Optional|Lazy $keyCount = new Optional(),
    ) {}

    public static function fromModel(Game $game): self
    {
        return new self(
            id: (string) $game->igdb_id,
            name: $game->name ?? 'Unknown',
            genres: Lazy::create(fn (): array => GenreData::collect($game->genres)->all()),
            screenshots: Lazy::create(fn (): array => ScreenshotData::collect($game->screenshots)->all()),
            description: $game->description ?? null,
            image: $game->image,
            keyCount: Lazy::create(fn () => $game->relationLoaded('keys')
                ? $game->keys->whereNull('owned_user_id')->count()
                : $game->keys()->whereNull('owned_user_id')->count()),
        );
    }

    public static function fromKey(Key $key): self
    {
        return self::from($key->game);
    }

    public static function fromIgdb(IgdbGame $igdbGame): self
    {
        $image = null;

        if ($igdbGame->cover && isset($igdbGame->cover->image_id)) {
            $image = 'https://images.igdb.com/igdb/image/upload/t_cover_big/'.$igdbGame->cover->image_id.'.jpg';
        }

        return new self(
            id: (string) $igdbGame->id,
            name: $igdbGame->name           ?? 'Unknown',
            genres: Lazy::create(fn (): array => GenreData::collect($igdbGame->genres)->all()),
            description: $igdbGame->summary ?? null,
            image: $image,
            keyCount: Lazy::create(function () use ($igdbGame) {
                $game = Game::where('igdb_id', $igdbGame->id)->first();

                if (! $game) {
                    return 0;
                }

                return $game->keys()
                    ->whereNull('owned_user_id')
                    ->count();
            }),
        );
    }
}
