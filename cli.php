<?php
require 'vendor/autoload.php';

if (!\Eddy\Framework\Setup\SetUp::isSetUp($dir = projectDir())) {
    \Eddy\Framework\Setup\SetUp::run($dir);
} else {
    $app = include_once 'bootstrap/app.php';

    /**
     * @var \Symfony\Component\Console\Application
     */
    $cli = $app[\Symfony\Component\Console\Application::class];
    
    $cli->run();
}

