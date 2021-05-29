<?php
namespace Eddy\Framework\Core\Providers;

use Eddy\Framework\Bootstrap\InitRouter;
use Eddy\Framework\Routing\RouteDispatcher;
use FastRoute\{
    DataGenerator,
    Dispatcher,
    RouteCollector,
    RouteParser
};
use FastRoute\DataGenerator\GroupCountBased;
use FastRoute\Dispatcher\GroupCountBased as GroupCountBasedDispatcher;
use FastRoute\RouteParser\Std as StdParser;
use Pimple\{
    Container,
    ServiceProviderInterface
};
use Psr\Http\Message\ServerRequestInterface;
use React\Http\Message\Response;

class RouterProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
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

        $app[RouteDispatcher::class] = function (Container $c) {
            return new RouteDispatcher($c[Dispatcher::class]);
        };
    }
}
