<?php
namespace Eddy\Framework\Server;

use Eddy\Framework\Core\Config;
use Eddy\Framework\Routing\RouteDispatcher;
use Pimple\{
    Container,
    ServiceProviderInterface
};
use Psr\Http\Message\ServerRequestInterface;
use React\EventLoop\{
    Factory,
    LoopInterface
};
use React\Http\{
    Message\Response,
    Server as HttpServer,
};
use React\Socket\Server as SocketServer;

class ServerProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app[LoopInterface::class] = function () {
            return Factory::create();
        };

        $app[HttpServer::class] = function (Container $c) {
            return new HttpServer(
                $c[LoopInterface::class],
                $c[RouteDispatcher::class]
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
            return new Server(
                $c[LoopInterface::class],
                $c[HttpServer::class],
                $c[SocketServer::class],
            );
        };
    }
}
