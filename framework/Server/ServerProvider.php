<?php
namespace Eddy\Framework\Server;

use Eddy\Config\Config;
use Eddy\Framework\Exceptions\ExceptionHandler;
use Eddy\Framework\Routing\ErrorHandler;
use Eddy\Framework\Routing\LoadMiddleware;
use Eddy\Framework\Routing\RouteDispatcher;
use Eddy\RefCon\ReflectionConstructor;
use Pimple\{
    Container,
    ServiceProviderInterface
};
// use Psr\Http\Message\ServerRequestInterface;
use React\EventLoop\{
    Factory,
    LoopInterface
};
use React\Http\{
    // Message\Response,
    Server as HttpServer,
};
use React\Socket\Server as SocketServer;

class ServerProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        if (!isset($app[LoopInterface::class])) {
            $app[LoopInterface::class] = function () {
                return Factory::create();
            };
        }

        $app[HttpServer::class] = function (Container $c) {
            $handler = [
                $c[ErrorHandler::class],
                ...(new LoadMiddleware(
                    $c[ReflectionConstructor::class],
                    $c[Config::class]['http.middleware']
                ))->load(),
                $c[RouteDispatcher::class]
            ];

            return new HttpServer(
                $c[LoopInterface::class],
                ...$handler,
            );
        };

        $app[SocketServer::class] = function (Container $c) {
            $config = $c[Config::class];
            return new SocketServer(
                "{$config['server.address']}:{$config['server.port']}",
                $c[LoopInterface::class]
            );
        };

        $app[Server::class] = function (Container $c) {
            $server = new Server(
                $c[LoopInterface::class],
                $c[HttpServer::class],
                $c[SocketServer::class],
            );

            $server->on(
                'error',
                fn(\Throwable $e) => call_user_func(
                    $c[ExceptionHandler::class],
                    $e
                )
            );

            return $server;
        };
    }
}
