<?php
if (file_exists(dirname(__DIR__) . '.env')) {
    Dotenv\Dotenv::createImmutable(dirname(__DIR__))->load();
}

// Create a new app
$app = \Eddy\Framework\Core\Kernel::create();

// Register services here
$app['logger.framework']->info('Hello logger');

return $app;
