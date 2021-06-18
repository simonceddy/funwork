<?php
namespace Eddy\Framework\Core\Providers;

use Eddy\Framework\{
    Bootstrap\InitRouter,
    Routing\ControllerResolver,
    Routing\RouteDispatcher,
};
use Eddy\Framework\Routing\ErrorHandler;
use Eddy\RefCon\ReflectionConstructor;
use FastRoute\{
    DataGenerator,
    Dispatcher,
    RouteCollector,
    RouteParser,
    DataGenerator\GroupCountBased,
    Dispatcher\GroupCountBased as GroupCountBasedDispatcher,
    RouteParser\Std as StdParser,
};
use Pimple\{
    Container,
    ServiceProviderInterface
};
use Psr\Log\LoggerInterface;

class RouterProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app[ErrorHandler::class] = function (Container $c) {
            return new ErrorHandler(
                isset($c[LoggerInterface::class])
                    ? $c[LoggerInterface::class]
                    : null
            );
        };

        $app[RouteParser::class] = function () {
            return new StdParser();
        };

        $app[DataGenerator::class] = function () {
            return new GroupCountBased();
        };

        $app[RouteCollector::class] = function (Container $c) {
            return (new InitRouter())->register(new RouteCollector(
                $c[RouteParser::class],
                $c[DataGenerator::class]
            ));
        };

        $app[Dispatcher::class] = function (Container $c) {
            return new GroupCountBasedDispatcher($c[RouteCollector::class]->getData());
        };

        $app[ControllerResolver::class] = function (Container $c) {
            return new ControllerResolver($c, $c[ReflectionConstructor::class]);
        };

        $app[RouteDispatcher::class] = function (Container $c) {
            return new RouteDispatcher(
                $c[Dispatcher::class],
                $c[ControllerResolver::class]
            );
        };
    }
}
