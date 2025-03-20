<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use MarcReichel\IGDBLaravel\Models\Game as Igdb;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Game extends Model implements HasMedia
{
    use HasUuids;
    use InteractsWithMedia;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'igdb_id',
        'igdb_updated',
        'created_user_id',
    ];

    protected $casts = [
        'igdb_updated' => 'date',
    ];

    /**
     * @return HasMany<Key, $this>
     */
    public function keys(): HasMany
    {
        return $this->hasMany(Key::class);
    }

    /**
     * @return HasMany<Key, $this>
     */
    public function unclaimedKeys(): HasMany
    {
        return $this->hasMany(Key::class)->whereNull('claimed_by_user_id');
    }

    public static function findOrCreateFromIgdb(string $name, int $userId): self
    {
        $game = static::where('name', $name)->first();

        if (! $game) {
            $game = static::createFromIgdb($name, $userId);
        }

        return $game;
    }

    protected static function createFromIgdb(string $name, int $userId): self
    {
        $game = new static(['name' => $name]);

        $igdb = Igdb::select(['name', 'summary', 'id'])
            ->with(['cover' => ['image_id']])
            ->where('name', '=', $name)
            ->first();

        if ($igdb) {
            $game->fill([
                'name' => $igdb->name,
                'description' => $igdb->summary,
                'igdb_id' => $igdb->id,
                'igdb_updated' => Carbon::today(),
            ]);

            if ($igdb->cover?->image_id) {
                $game->addMediaFromUrl("https://images.igdb.com/igdb/image/upload/t_cover_big/{$igdb->cover->image_id}.jpg")
                    ->toMediaCollection('cover');
            }
        }

        $game->created_user_id = $userId;
        $game->save();

        return $game;
    }
}
