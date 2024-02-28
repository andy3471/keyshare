<?php

namespace App\Http\ViewComposers;

use App\Models\Platform;
use Cache;
use Illuminate\View\View;

class PlatformViewComposer
{
    public function __construct()
    {
        $this->platforms = Cache::remember('platforms', 3600, function () {
            return Platform::all();
        });
    }

    public function compose(View $view)
    {
        $view->with('platforms', $this->platforms);
    }
}
