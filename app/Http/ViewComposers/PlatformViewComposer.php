<?php

namespace App\Http\ViewComposers;

use App\Models\Platform;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class PlatformViewComposer
{
    // TODO: Move this to the model
    public function compose(View $view): void
    {
        $platforms = Cache::remember('platforms', 60 * 60 * 24, function () {
            return Platform::all();
        });

        $view->with('platforms', $platforms);
    }
}
