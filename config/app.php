<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Facade;

return [
    'demo_mode' => env('APP_DEMO_MODE', false),

    'aliases' => Facade::defaultAliases()->merge([
        'Redis' => Illuminate\Support\Facades\Redis::class,
    ])->toArray(),
];
