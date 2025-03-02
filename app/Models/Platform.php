<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Platform extends Model
{
    use HasUuids;

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
