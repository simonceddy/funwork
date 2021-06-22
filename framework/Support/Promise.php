<?php
namespace Eddy\Framework\Support;

use React\Promise\PromiseInterface;

class Promise implements PromiseInterface
{
    public function then(
        ?callable $onFulfilled = null,
        ?callable $onRejected = null,
        ?callable $onProgress = null
    ) {
        
    }
}
