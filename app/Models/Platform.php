<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Platform extends Model
{
    /**
     * @param $platform_id
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function getPlatformWithKeys($platform_id) {
        return DB::table('games')
            ->distinct()
            ->selectRaw('games.id, games.name, games.image')
            ->join('keys', 'keys.game_id', '=', 'games.id')
            ->where('keys.owned_user_id', '=', null)
            ->where('games.removed', '=', '0')
            ->where('keys.removed', '=', '0')
            ->where('keys.platform_id', '=', $platform_id)
            ->orderby('games.name')
            ->paginate(12);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function keys()
    {
        return $this->hasMany('App\Models\Key');
    }
}
