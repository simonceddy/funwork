<?php

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

// Work in progress - a bit brittle
return [
    // Configure any framework loggers
    'loggers' => [
        // the created logger will be named 'logger.$key'
        // e.g. below the created logger will be called 'logger.framework'
        'framework' => [
            // List logger handlers here
            StreamHandler::class
        ],
    ],

    // Configure handlers here
    'handlers' => [
        StreamHandler::class => [dirname(__DIR__) . '/storage/logs/framework.log', Logger::DEBUG]
    ]
];
