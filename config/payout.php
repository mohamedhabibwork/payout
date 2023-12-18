<?php

return [
    'hyper_split' => [
        'mode' => env('HYPER_SPLIT_MODE', 'test'),
        'email' => env('HYPER_SPLIT_EMAIL'),
        'password' => env('HYPER_SPLIT_PASSWORD'),
        'live' => [
            'url' => env('HYPER_SPLIT_LIVE_URL', 'https://splits.hyperpay.com'),
        ],
        'test' => [
            'url' => env('HYPER_SPLIT_TEST_URL', 'https://splits.sandbox.hyperpay.com'),
        ],
        'config_id' => env('HYPER_SPLIT_CONFIG_ID'),
        'notification_key' => env('HYPER_SPLIT_NOTIFICATION_KEY'),
    ]
];
