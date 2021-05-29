<?php
require 'vendor/autoload.php';

$app = include_once 'bootstrap/app.php';

/**
 * @var \Symfony\Component\Console\Application
 */
$cli = $app[\Symfony\Component\Console\Application::class];

$cli->run();
