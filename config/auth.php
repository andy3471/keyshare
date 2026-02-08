<?php

declare(strict_types=1);

return [

    'guards' => [
        'api' => [
            'driver'   => 'token',
            'provider' => 'users',
            'hash'     => false,
        ],
    ],

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table'    => 'password_resets',
            'expire'   => 60,
            'throttle' => (int) env('PASSWORD_RESET_THROTTLE', 60),
        ],
    ],

];
