<?php
namespace Eddy\Framework\Support\Traits;

use React\Http\Message\Response;

/**
 * Basic http controller helpers
 */
trait CanSendResponse
{
    public function respond(string $body = '')
    {
        return new Response(200, [], $body);
    }
}
