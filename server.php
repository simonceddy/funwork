<?php
require 'vendor/autoload.php';

$app = include_once 'bootstrap/app.php';

$server = $app[\Eddy\Framework\Server\Server::class];

// dd($server);
$server->run();
