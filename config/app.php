<?php
// This file contains general app config

return [
    'environment' => 'dev',
    'name' => env('APP_NAME', 'Eddy Framework'),
    'version' => env('APP_VERSION', '1.0.0'),

    'namespace' => 'App',

    // You can register service providers here
    'providers' => [
        App\Providers\AppProvider::class,
    ],
];
