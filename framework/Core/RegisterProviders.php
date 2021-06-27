<?php
namespace Eddy\Framework\Core;

use Eddy\Config\Config;
use Eddy\Framework\Core\Kernel;
use Eddy\Framework\Exceptions\ExceptionHandler;
use Eddy\Framework\Filesystem\Filesystem;
use Eddy\Framework\Support\Logging\LoggingProvider;
use Eddy\RefCon\ReflectionConstructor;
use Pimple\{
    Container,
    ServiceProviderInterface
};
use React\EventLoop\{
    Factory,
    LoopInterface
};
use Symfony\Component\Filesystem\Filesystem as SymfonyFs;

class RegisterProviders implements ServiceProviderInterface
{
    public function __construct(private Kernel $kernel)
    {}

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

    public function register(Container $app)
    {
        $config = $this->kernel->config();

        $app[Kernel::class] = fn() => $this->kernel;
        $app[Config::class] = fn() => $config;
        
        $app[LoopInterface::class] = function () {
            return Factory::create();
        };

        $app[Filesystem::class] = function (Container $c) {
            return Filesystem::create($c[LoopInterface::class]);
        };

        // alias symfony filesystem
        $app[SymfonyFs::class] = function (Container $c) {
            return $c[Filesystem::class];
        };

        $app[ReflectionConstructor::class] = function (Container $c) {
            return new ReflectionConstructor(
                $c[Kernel::class]
            );
        };

        $app[ExceptionHandler::class] = function (Container $c) {
            return new ExceptionHandler($c[Kernel::class]);
        };

        $app->register(new LoggingProvider());

        $providers = $config['app.providers'];

        if (!empty($providers)) {
            $this->bootProviders($this->kernel, $providers);
        }
    }
}
