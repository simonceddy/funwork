<?php
namespace Eddy\Framework\Exceptions;

use Eddy\Framework\Core\Kernel;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;

class ExceptionHandler
{
    public function __construct(
        private Kernel $kernel,
        private ? OutputInterface $output = null
    ) {
        if (!isset($output)) {
            $this->output = isset($kernel[OutputInterface::class])
                ? $kernel[OutputInterface::class]
                : new ConsoleOutput();
        }
    }

    public function __invoke(\Throwable $e)
    {
        $this->kernel->error((string) $e);

        $this->output->writeln("<error>ERROR</error>\n{$e->getMessage()}");
        
        return 0;
    }
}
