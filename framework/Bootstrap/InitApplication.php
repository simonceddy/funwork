<?php
namespace Eddy\Framework\Bootstrap;

use Eddy\Framework\Core\Kernel;
use Eddy\Framework\Exceptions\ExceptionHandler;

class InitApplication
{
    public function boot(Kernel $kernel)
    {
        if ($kernel->has('logger.framework')
            && $kernel->has(ExceptionHandler::class)
        ) {
            $kernel->setLogger($kernel->get('logger.framework'));

            set_exception_handler($kernel[ExceptionHandler::class]);
        }

        return $kernel;
    }
}
