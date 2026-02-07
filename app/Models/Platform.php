<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Platform extends Model
{
    use HasUuids;

    protected $fillable = [
        'name',
        'igdb_id',
    ];

    /** @return HasMany<Key, $this> */
    public function keys(): HasMany
    {
        return $this->hasMany(Key::class);
    }
}
