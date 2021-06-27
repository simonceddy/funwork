<?php
use FastRoute\RouteCollector as Routes;
use Psr\Http\Message\ServerRequestInterface as Request;
use React\Http\Message\Response;

return function (Routes $routes) {
    // Put web routes here

    // Routes are callables:
    $routes->get('/', function (Request $request) {
        return new Response(200, [], 'Hello World!');
    });
    
    // Or invokable classes:
    // $routes->get('/stats', App\Htto\Controllers\MyController::class);
};
