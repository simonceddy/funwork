<?php
namespace App\Http\Controllers;

use Eddy\Framework\Support\Traits\CanSendResponse;
use Psr\Http\Message\ServerRequestInterface as Request;
use React\Http\Message\Response;

class FrontController
{
    use CanSendResponse;

    /**
     * Add controller logic below
     *
     * @param Request $request
     *
     * @return Response
     */
    public function __invoke(Request $request)
    {
        // asdad
        return $this->respond('Hello World');
    }
}
