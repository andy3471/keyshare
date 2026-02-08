<?php

declare(strict_types=1);

namespace App\DataTransferObjects\Games;

use App\DataTransferObjects\Platforms\PlatformData;
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
     * @param  PlatformData[]|Optional|Lazy  $platforms
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
        public Optional|Lazy|array $platforms = new Optional(),
    ) {}

    public static function fromModel(Game $game): self
    {
        return new self(
            id: (string) $game->igdb_id,
            name: $game->name ?? 'Unknown',
            genres: Lazy::create(fn (): array => $game->genres ? GenreData::collect($game->genres)->all() : []),
            screenshots: Lazy::create(fn (): array => $game->screenshots ? ScreenshotData::collect($game->screenshots)->all() : []),
            description: $game->description ?? null,
            image: $game->image,
            keyCount: Lazy::create(fn () => $game->relationLoaded('keys')
                ? $game->keys->whereNull('owned_user_id')->count()
                : $game->keys()->whereNull('owned_user_id')->count()),
            platforms: Lazy::create(fn (): array => $game->relationLoaded('keys')
                ? PlatformData::collect(
                    $game->keys->whereNull('owned_user_id')
                        ->pluck('platform')->filter()->unique('id')->values()
                )->all()
                : []),
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
            genres: Lazy::create(fn (): array => $igdbGame->genres ? GenreData::collect($igdbGame->genres)->all() : []),
            description: $igdbGame->summary ?? null,
            image: $image,
            keyCount: Lazy::create(function () use ($igdbGame) {
                $game = Game::where('igdb_id', $igdbGame->id)->first();

                if (! $game) {
                    return 0;
                }

                return self::scopedKeyQuery($game)->count();
            }),
            platforms: Lazy::create(function () use ($igdbGame): array {
                $game = Game::where('igdb_id', $igdbGame->id)->first();

                if (! $game) {
                    return [];
                }

                return PlatformData::collect(
                    self::scopedKeyQuery($game)
                        ->with('platform')
                        ->get()
                        ->pluck('platform')->filter()->unique('id')->values()
                )->all();
            }),
        );
    }

    /** @return \Illuminate\Database\Eloquent\Relations\HasMany<Key, Game> */
    private static function scopedKeyQuery(Game $game): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        $activeGroupId = session('active_group_id');
        $userGroupIds  = auth()->check() ? auth()->user()->groups->pluck('id') : collect();

        return $game->keys()
            ->whereNull('owned_user_id')
            ->when(
                $activeGroupId,
                fn ($q) => $q->where('group_id', $activeGroupId),
                fn ($q) => $q->whereIn('group_id', $userGroupIds),
            );
    }
}
