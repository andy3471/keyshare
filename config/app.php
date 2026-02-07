<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Facade;

return [
    'aliases' => Facade::defaultAliases()->merge([
        'Redis' => Illuminate\Support\Facades\Redis::class,
    ])->toArray(),
];
