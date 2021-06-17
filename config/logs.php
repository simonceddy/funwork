<?php

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

// Work in progress - a bit brittle
return [
    // Set tot true to disable logging, preventing any logging services from
    // being registered
    'disable' => false,

    // Configure any framework loggers
    'loggers' => [
        // the created logger will be named after the child arrays key
        // e.g. below the created logger will be called 'framework'
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
