<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class KeyType extends Model
{
    public const GAME = 1;
    public const DLC = 2;
    public const WALLET = 3;
    public const SUBSCRIPTION = 4;

    protected $fillable = [
        'name',
    ];

    /**
     * Get KeyType ID by name
     */
    public static function getIdByName(string $name): ?int
    {
        $id = Cache::remember("key_type_{$name}", 3600, function () use ($name) {
            return self::where('name', $name)->value('id');
        });
        
        return $id ? (int) $id : null;
    }

}
