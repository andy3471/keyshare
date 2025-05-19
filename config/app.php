<?php

use Illuminate\Support\Facades\Facade;

return [

    'demo_mode' => env('APP_DEMO_MODE', false),

    'dlc_enabled' => env('DLC_ENABLED', true),

    'aliases' => Facade::defaultAliases()->merge([
        'Redis' => Illuminate\Support\Facades\Redis::class,
    ])->toArray(),

];
