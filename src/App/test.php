<?php
namespace %namespace*;

use Psr\Http\Message\ServerRequestInterface as Request;
use React\Http\Message\Response;

class *name*
{
    public function __invoke(Request $request)
    {
        return new Response(200, [], 'Hello World');
    }
}