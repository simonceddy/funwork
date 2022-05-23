<?php

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

// Work in progress - a bit brittle
return [
    // Configure any framework loggers
    'loggers' => [
        // the created logger will be named 'logger.$key'
        // e.g. below the created logger will be called 'logger.framework'
        // Loggers can be accessed with these names from the app container
        // e.g. $app['logger.framework'] will return the logger called
        // 'logger.framework'
        'framework' => [
            // List logger handlers here
            StreamHandler::class
        ],
    ],

    // Configure handlers here
    'handlers' => [
        // Handler class name as key => constructor args as array values
        StreamHandler::class => [
            dirname(__DIR__) . '/storage/logs/framework.log',
            Logger::DEBUG
        ],
    ]
];
