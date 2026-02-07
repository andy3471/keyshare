<?php

declare(strict_types=1);

return [
    'enabled'     => true, // Always enabled
    'update_freq' => env('TWITCH_UPDATE_FREQ', 180),

    /*
     * These are the credentials you got from https://dev.twitch.tv/console/apps
     */
    'credentials' => [
        'client_id'     => env('TWITCH_CLIENT_ID', ''),
        'client_secret' => env('TWITCH_CLIENT_SECRET', ''),
    ],

    /*
     * This package caches queries automatically (for 1 hour per default).
     * Here you can set how long each query should be cached (in seconds).
     *
     * To turn cache off set this value to 0
     */
    'cache_lifetime' => env('TWITCH_CACHE_LIFETIME', 3600),

    /*
     * This is the per-page limit for your tier.
     */
    'per_page_limit' => 500,
];
