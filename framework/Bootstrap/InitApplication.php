<?php
namespace Eddy\Framework\Bootstrap;

use Eddy\Framework\Core\Kernel;
use Eddy\Framework\Exceptions\ExceptionHandler;
use Symfony\Component\Console\Output\OutputInterface;

class InitApplication
{
    private function bootProvider(Kernel $kernel, $provider)
    {
        if (is_string($provider) && class_exists($provider)) {
            try {
                $kernel->register(new $provider());
            } catch (\Throwable $e) {
                // Handle error
                throw $e;
            } 
        }
    }

    private function bootProviders(Kernel $kernel, array $providers)
    {
        foreach ($providers as $index => $provider) {
            $this->bootProvider($kernel, $provider);
        }
    }

    public function boot(Kernel $kernel)
    {
        $config = $kernel->config();

        $providers = $config['app.providers'];

        if (!empty($providers)) {
            $this->bootProviders($kernel, $providers);
        }

        if ($kernel->has('logger.framework')
            && $kernel->has(ExceptionHandler::class)
        ) {
            $kernel->setLogger($kernel->get('logger.framework'));

            set_exception_handler($kernel[ExceptionHandler::class]);
        }

        return $kernel;
    }
}
