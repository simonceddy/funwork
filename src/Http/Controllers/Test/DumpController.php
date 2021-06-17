<?php
namespace App\Http\Controllers\Test;

use Eddy\Framework\Core\Kernel;
use Eddy\Framework\Support\Traits\CanSendResponse;
use Psr\Http\Message\ServerRequestInterface as Request;
use React\Http\Message\Response;

class DumpController
{
    use CanSendResponse;

    public function __construct(private Kernel $kernel)
    {}

    /**
     * Add controller logic below
     *
     * @param Request $request
     *
     * @return Response
     */
    public function __invoke(Request $request)
    {
        // dump(serialize($this->kernel));
        return $this->respond('here is the kernz');
    }
}
