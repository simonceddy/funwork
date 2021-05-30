<?php
namespace App\Http\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;

class MyCoolMiddleware
{
    public function __invoke(Request $request, callable $next)
    {
        // Put middleware logic here
        dump((string) $request->getUri());
        return $next($request);
    }
}
