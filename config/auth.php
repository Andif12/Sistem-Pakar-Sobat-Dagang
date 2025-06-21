<?php

return [
    'defaults' => [
        'guard' => env('AUTH_GUARD', 'web'),
        'passwords' => env('AUTH_PASSWORD_BROKER', 'users'),
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'disdag' => [
            'driver' => 'session',
            'provider' => 'disdags',
        ],
        'user' => [ 
            'driver' => 'session',
            'provider' => 'user',
        ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],
        'user' => [
                'driver' => 'eloquent',
                'model' => App\Models\User::class,
            ],
        'disdags' => [
            'driver' => 'eloquent',
            'model' => App\Models\Disdag::class,
        ],
    ],

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => env('AUTH_PASSWORD_RESET_TABLE', 'password_resets'),
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),
];
