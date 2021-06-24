<?php
namespace App\Http\Controllers\Test;

use Eddy\Framework\Support\Traits\CanSendResponse;
use Psr\Http\Message\ServerRequestInterface as Request;
use React\Http\Message\Response;

class FunController
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
        return $this->respond('Hello World');
    }
}
