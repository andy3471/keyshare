<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Platform extends Model
{
    use HasUuids;

    /** @var array<string, string> */
    private const array ICON_MAP = [
        'steam'           => 'steam',
        'origin'          => 'origin',
        'ea app'          => 'origin',
        'uplay'           => 'uplay',
        'ubisoft connect' => 'uplay',
        'epic games'      => 'epic-games',
        'gog'             => 'gog',
        'windows store'   => 'windows',
        'microsoft store' => 'windows',
        'battle.net'      => 'battlenet',
        'playstation 4'   => 'playstation',
        'playstation 5'   => 'playstation',
        'xbox one'        => 'xbox',
        'xbox series x|s' => 'xbox',
        'nintendo switch' => 'nintendo',
    ];

    protected $fillable = [
        'name',
    ];

    /** Resolve the icon slug for this platform. */
    public function icon(): string
    {
        return self::ICON_MAP[mb_strtolower(mb_trim($this->name))] ?? 'generic';
    }

    /** @return HasMany<Key, $this> */
    public function keys(): HasMany
    {
        return $this->hasMany(Key::class);
    }
}
