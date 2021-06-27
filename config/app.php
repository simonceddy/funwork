<?php
// This file contains general app config

return [
    'environment' => 'dev',
    'name' => env('APP_NAME', 'Eddy Framework'),
    'version' => env('APP_VERSION', '1.0.0'),

    'namespace' => 'App',

    'providers' => [
        // Framework providers
        Eddy\Framework\Http\HttpProvider::class,
        Eddy\Framework\Routing\RouterProvider::class,
        Eddy\Framework\Server\ServerProvider::class,
        Eddy\Framework\Resources\ResourcesProvider::class,
        Eddy\Framework\Console\ConsoleProvider::class,

        // Register additional providers here
        // App\Providers\AppProvider::class,
    ],
];
