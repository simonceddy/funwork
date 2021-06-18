<?php
return [
    'port' => env('SERVER_PORT', 3033),
    'address' => env('SERVER_ADDRESS', '127.0.0.1'),

    // A list of paths from which to serve static files
    'static' => [
        dirname(__DIR__) . '/public'
    ]
];
