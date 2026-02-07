<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use MarcReichel\IGDBLaravel\Models\Game as IgdbGame;

class Game extends Model
{
    use HasUuids;

    protected $appends = [
        'url',
        'name',
        'description',
        'image',
    ];

    protected $fillable = [
        'igdb_id',
    ];

    public static function fromIgdbId(int $igdbId): ?self
    {
        $existing = self::where('igdb_id', $igdbId)->first();

        if ($existing) {
            return $existing;
        }

        $igdbId = IgdbGame::select(['name', 'summary', 'id', 'parent_game'])->where('id', '=', $igdbId)->first();

        if ($igdbId) {
            return self::createFromIgdb($igdbId);
        }

        return null;
    }

    public static function createFromIgdb(
        IgdbGame $igdbGame,
    ): self {
        $game = self::where('igdb_id', $igdbGame->id)->first();

        if ($game) {
            return $game;
        }

        $game          = new self;
        $game->igdb_id = $igdbGame->id;
        $game->save();

        return $game;
    }

    /** @return HasMany<Key, $this> */
    public function keys(): HasMany
    {
        return $this->hasMany(Key::class);
    }

    public function getIgdbData(): ?IgdbGame
    {
        if (! $this->igdb_id || ! config('igdb.enabled')) {
            return null;
        }

        static $cache = [];
        $cacheKey     = 'igdb_'.$this->igdb_id;

        if (! isset($cache[$cacheKey])) {
            $cache[$cacheKey] = IgdbGame::select([
                'name',
                'summary',
                'id',
                'parent_game',
                'aggregated_rating',
                'aggregated_rating_count',
            ])
                ->with(['cover' => ['image_id'], 'genres', 'screenshots', 'dlcs'])
                ->where('id', '=', $this->igdb_id)
                ->first();
        }

        return $cache[$cacheKey];
    }

    /** @return Attribute<string, never> */
    protected function url(): Attribute
    {
        return Attribute::make(
            get: function (): string {
                return route('games.show', $this->igdb_id);
            }
        );
    }

    /** @return Attribute<string, never> */
    protected function name(): Attribute
    {
        return Attribute::make(get: function () {
            $igdb = $this->getIgdbData();

            return $igdb?->name;
        });
    }

    /** @return Attribute<string, never> */
    protected function description(): Attribute
    {
        return Attribute::make(get: function () {
            $igdb = $this->getIgdbData();

            return $igdb?->summary;
        });
    }

    /** @return Attribute<string, ?string> */
    protected function image(): Attribute
    {
        return Attribute::make(get: function (): ?string {
            $igdb = $this->getIgdbData();
            if ($igdb instanceof IgdbGame && $igdb->cover && isset($igdb->cover->image_id)) {
                return 'https://images.igdb.com/igdb/image/upload/t_cover_big/'.$igdb->cover->image_id.'.jpg';
            }

            return null;
        });
    }
}
