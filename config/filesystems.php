<?php

declare(strict_types=1);

return [
    'default' => env('FILESYSTEM_DISK', 'public'),

    'disks' => [
        'local' => [
            'driver' => 'local',
            'root'   => storage_path('app'),
        ],

        'public' => [
            'driver'                  => 's3',
            'key'                     => env('R2_ACCESS_KEY_ID'),
            'secret'                  => env('R2_SECRET_ACCESS_KEY'),
            'region'                  => 'auto',
            'bucket'                  => env('R2_PUBLIC_BUCKET'),
            'url'                     => env('R2_PUBLIC_URL'),
            'endpoint'                => env('R2_ENDPOINT'),
            'use_path_style_endpoint' => false,
            'throw'                   => false,
        ],

        'private' => [
            'driver'                  => 's3',
            'key'                     => env('R2_ACCESS_KEY_ID'),
            'secret'                  => env('R2_SECRET_ACCESS_KEY'),
            'region'                  => 'auto',
            'bucket'                  => env('R2_PRIVATE_BUCKET'),
            'endpoint'                => env('R2_ENDPOINT'),
            'use_path_style_endpoint' => false,
            'throw'                   => false,
        ],
    ],

];
