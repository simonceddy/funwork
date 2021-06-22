<?php

use Eddy\Framework\Http\Messages\JsonResponse;
use FastRoute\RouteCollector as Routes;
use Psr\Http\Message\ServerRequestInterface as Request;
use React\Http\Message\Response;

return function (Routes $routes) {
    // Put api routes here
    $routes->get('/hello', function (Request $request) {
        return JsonResponse::ok(['message' => 'yeeeeeeeeeee']);
    });
};
