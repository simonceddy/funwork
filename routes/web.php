<?php

use App\Http\Controllers\Test;
use FastRoute\RouteCollector as Routes;

return function (Routes $routes) {
    // Put web routes here
    $routes->get('/', Test::class);
};
