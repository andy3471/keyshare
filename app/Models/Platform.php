<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Platform extends Model
{
    /**
     * @return HasMany<Key, $this>
     */
    public function keys(): HasMany
    {
        return $this->hasMany(Key::class);
    }
}
