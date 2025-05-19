<?php

return [

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => \App\Models\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
        'webhook' => [
            'secret' => env('STRIPE_WEBHOOK_SECRET'),
            'tolerance' => env('STRIPE_WEBHOOK_TOLERANCE', 300),
        ],
    ],

    'steam' => [
        'client_id' => env('STEAM_API_KEY'),
        'client_secret' => env('STEAM_API_KEY'),
        'redirect' => env('APP_URL').'/login/steam/callback',
        'api_key' => env('STEAM_API_KEY'),
    ],

    'discord' => [
        'enabled' => env('DISCORD_ENABLED', false),
        'token' => env('DISCORD_TOKEN', ''),
        'channel' => env('DISCORD_CHANNEL', ''),
    ],

];
