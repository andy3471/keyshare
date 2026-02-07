<?php

declare(strict_types=1);

namespace App\Http\Controllers\Front;

use App\DataTransferObjects\PlatformData;
use App\Http\Controllers\Controller;
use App\Models\Platform;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class PlatformController extends Controller
{
    public function show(Request $request, Platform $platform): Response
    {
        $games = DB::table('games')
            ->distinct()
            ->selectRaw("games.id, games.name, CASE WHEN igdb_id IS NULL THEN concat('/', games.image) ELSE games.image END as image, concat('/games/', games.id) as url")
            ->join('keys', 'keys.game_id', '=', 'games.id')
            ->where('keys.owned_user_id', '=', null)
            ->where('games.removed', '=', '0')
            ->where('keys.removed', '=', '0')
            ->where('keys.platform_id', '=', $platform->id)
            ->oldest('games.name')
            ->paginate(12);

        return Inertia::render('Platforms/Show', [
            'platform' => PlatformData::fromModel($platform),
            'games' => Inertia::scroll(fn () => $games),
        ]);
    }
}
