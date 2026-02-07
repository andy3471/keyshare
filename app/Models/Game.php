<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Game extends Model
{
    use HasFactory;

    protected $appends = [
        'url',
    ];

    protected $fillable = [
        'name',
        'description',
        'created_user_id',
        'image',
        'igdb_id',
        'igdb_updated',
    ];

    /**
     * @return HasMany<Dlc, $this>
     */
    public function dlcs(): HasMany
    {
        return $this->hasMany(Dlc::class);
    }

    /**
     * @return HasMany<Key, $this>
     */
    public function keys(): HasMany
    {
        return $this->hasMany(Key::class);
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_user_id');
    }

    protected function url(): Attribute
    {
        return Attribute::make(
            get: function (): string {
                return route('games.show', $this->id);
            }
        );
    }
}
