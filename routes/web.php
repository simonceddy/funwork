<?php

use App\Http\Controllers\FrontController;
use FastRoute\RouteCollector as Routes;

return function (Routes $routes) {
    // Put web routes here
    $routes->get('/', FrontController::class);
};
