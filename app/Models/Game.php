<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    /**
     * Create or update a Game from IGDB data
     *
     * @param  \MarcReichel\IGDBLaravel\Models\Game  $igdbGame  The IGDB game model
     * @param  string|null  $createdUserId  Optional user ID (kept for backwards compatibility, but not stored)
     */
    public static function createFromIgdb(
        \MarcReichel\IGDBLaravel\Models\Game $igdbGame,
        ?string $createdUserId = null
    ): self {
        // Check if game already exists by IGDB ID
        $game = self::where('igdb_id', $igdbGame->id)->first();

        if ($game) {
            return $game;
        }

        // Create new game - only store igdb_id
        $game          = new self;
        $game->igdb_id = $igdbGame->id;
        $game->save();

        return $game;
    }

    /**
     * @return HasMany<Key, $this>
     */
    public function keys(): HasMany
    {
        return $this->hasMany(Key::class);
    }

    /**
     * Get IGDB data for this game (cached for the request)
     * Returns null if game doesn't have an IGDB ID or IGDB is not enabled
     */
    public function getIgdbData(): ?\MarcReichel\IGDBLaravel\Models\Game
    {
        if (! $this->igdb_id || ! config('igdb.enabled')) {
            return null;
        }

        // Cache IGDB data for this request to avoid multiple API calls
        static $cache = [];
        $cacheKey     = 'igdb_'.$this->igdb_id;

        if (! isset($cache[$cacheKey])) {
            $cache[$cacheKey] = \MarcReichel\IGDBLaravel\Models\Game::select([
                'name',
                'summary',
                'id',
                'parent_game', // Explicitly select parent_game field
                'aggregated_rating',
                'aggregated_rating_count',
            ])
                ->with(['cover' => ['image_id'], 'genres', 'screenshots', 'dlcs'])
                ->where('id', '=', $this->igdb_id)
                ->first();
        }

        return $cache[$cacheKey];
    }

    protected function url(): Attribute
    {
        return Attribute::make(
            get: function (): string {
                return route('games.show', $this->igdb_id);
            }
        );
    }

    /**
     * Get name from IGDB
     */
    protected function name(): Attribute
    {
        return Attribute::make(get: function () {
            $igdb = $this->getIgdbData();

            return $igdb?->name;
        });
    }

    /**
     * Get description from IGDB
     */
    protected function description(): Attribute
    {
        return Attribute::make(get: function () {
            $igdb = $this->getIgdbData();

            return $igdb?->summary;
        });
    }

    /**
     * Get image URL from IGDB
     */
    protected function image(): Attribute
    {
        return Attribute::make(get: function (): ?string {
            $igdb = $this->getIgdbData();
            if ($igdb instanceof \MarcReichel\IGDBLaravel\Models\Game && $igdb->cover && isset($igdb->cover->image_id)) {
                return 'https://images.igdb.com/igdb/image/upload/t_cover_big/'.$igdb->cover->image_id.'.jpg';
            }

            return null;
        });
    }

}
