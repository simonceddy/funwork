<?php
namespace App\Http\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use React\Http\Message\Response;

class Test
{
    public function __invoke(Request $request)
    {
        return new Response(200, [], 'Hello World');
    }
}
