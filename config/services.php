<?php

declare(strict_types=1);

return [

    'mailgun' => [
        'domain'   => env('MAILGUN_DOMAIN'),
        'secret'   => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model'   => App\Models\User::class,
        'key'     => env('STRIPE_KEY'),
        'secret'  => env('STRIPE_SECRET'),
        'webhook' => [
            'secret'    => env('STRIPE_WEBHOOK_SECRET'),
            'tolerance' => env('STRIPE_WEBHOOK_TOLERANCE', 300),
        ],
    ],

    'steam' => [
        'client_id'     => null,
        'client_secret' => env('STEAM_CLIENT_SECRET'),
        'redirect'      => env('APP_URL').'/auth/steam/callback',
        'allowed_hosts' => [
            'sparekey.club',
        ]
    ],

    'twitch' => [
        'client_id'     => env('TWITCH_CLIENT_ID'),
        'client_secret' => env('TWITCH_CLIENT_SECRET'),
        'redirect'      => env('APP_URL').'/auth/twitch/callback',
    ],

    'discord' => [
        'client_id'     => env('DISCORD_CLIENT_ID'),
        'client_secret' => env('DISCORD_CLIENT_SECRET'),
        'redirect'      => env('APP_URL').'/auth/discord/callback',
    ],

    'microsoft' => [
        'client_id'     => env('MICROSOFT_CLIENT_ID'),
        'client_secret' => env('MICROSOFT_CLIENT_SECRET'),
        'redirect'      => env('APP_URL').'/auth/xbox/callback',
        'tenant'        => 'consumers',
    ],

];
