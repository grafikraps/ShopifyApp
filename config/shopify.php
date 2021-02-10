<?php

return [
    'public' => env('SHOPIFY_PUBLIC'),
    'private' => env('SHOPIFY_PRIVATE'),
    'scope' => explode(',', env('SHOPIFY_SCOPE')),
    'api_version' => '2021-01',

    'views' => [
        'app' => env('SHOPIFY_VIEWS_APP', 'app'),
        'login' => env('SHOPIFY_VIEWS_LOGIN', 'login'),
    ],
];
