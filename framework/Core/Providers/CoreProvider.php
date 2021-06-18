<?php
namespace Eddy\Framework\Core\Providers;

use Eddy\Framework\{
    // Core\Config,
    Core\Kernel,
    Resources\ResourcesProvider,
    Server\ServerProvider,
};
use Eddy\Framework\Console\ConsoleProvider;
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

class CoreProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
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

        $app->register(new HttpProvider());
        $app->register(new RouterProvider());
        $app->register(new ServerProvider());
        $app->register(new ResourcesProvider());
        $app->register(new ConsoleProvider());
    }
}
