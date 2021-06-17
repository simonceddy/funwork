<?php
namespace Eddy\Framework\Core\Providers;

use Eddy\Framework\{
    // Core\Config,
    Core\Kernel,
    Resources\ResourcesProvider,
    Server\ServerProvider,
};
use Eddy\Framework\Support\Logging\LoggingProvider;
use Eddy\RefCon\ReflectionConstructor;
use Pimple\{
    Container,
    ServiceProviderInterface
};
use Symfony\Component\Filesystem\Filesystem;

class CoreProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app[Filesystem::class] = function () {
            return new Filesystem();
        };

        $app[ReflectionConstructor::class] = function (Container $c) {
            return new ReflectionConstructor(
                $c[Kernel::class]
            );
        };

        /**
         * @var Kernel
         */
        $kernel = $app[Kernel::class];

        if ($kernel->loggingEnabled()) {
            $app->register(new LoggingProvider());
        }

        $app->register(new HttpProvider());
        $app->register(new RouterProvider());
        $app->register(new ServerProvider());
        $app->register(new ResourcesProvider());
    }
}
