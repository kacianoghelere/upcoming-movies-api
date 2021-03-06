<?php

return [
    'paths' => ['api/*'],
    'allowed_methods' => [
        'GET',
        'OPTIONS'
    ],
    'allowed_origins' => ['*'],
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'],
    'exposed_headers' => false,
    'max_age' => false,
    'supports_credentials' => false,
];
