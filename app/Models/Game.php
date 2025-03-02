<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Game extends Model implements HasMedia
{
    use HasUuids;
    use InteractsWithMedia;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'created_by_user_id',
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
}
