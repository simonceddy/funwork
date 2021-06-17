<?php
namespace Eddy\Framework\Exceptions;

use Eddy\Framework\Core\Kernel;

class ExceptionHandler
{
    public function __construct(private Kernel $kernel)
    {}

    public function __invoke(\Throwable $e)
    {
        $this->kernel->error((string) $e);

        echo 'ERROR' . PHP_EOL;
        echo $e->getMessage() . PHP_EOL;
        
        return 0;
    }
}
