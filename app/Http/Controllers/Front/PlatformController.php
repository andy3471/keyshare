<?php

declare(strict_types=1);

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Platform;
use Illuminate\View\View;

class PlatformController extends Controller
{
    public function show(Platform $platform): View
    {
        return view('games.index')
            ->withTitle($platform->name)
            ->withurl(route('api.platforms.show', $platform->id));
    }
}
