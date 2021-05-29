<?php
use FastRoute\RouteCollector as Routes;
use Psr\Http\Message\ServerRequestInterface as Request;
use React\Http\Message\Response;

return function (Routes $routes) {
    // Put api routes here
    $routes->get('/hello', function (Request $request) {
        return new Response(
            200,
            ['Content-Type' => 'application/json'],
            json_encode(['message' => 'Hello from me, Simon of Eddy']));
    });
};
