<?php

use App\Http\Controllers\FrontController;
use App\Http\Controllers\Test\DumpController;
use FastRoute\RouteCollector as Routes;

return function (Routes $routes) {
    // Put web routes here
    $routes->get('/', FrontController::class);
    // $routes->get('/dump', DumpController::class);
};
