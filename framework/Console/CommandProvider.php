<?php
namespace Eddy\Framework\Console;

use Eddy\Coder\Creator;
use Eddy\Framework\{
    Core\Config,
    Server\Server
};
use Pimple\{
    Container,
    ServiceProviderInterface
};
use Symfony\Component\Filesystem\Filesystem;

class CommandProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app[Commands\ServeCommand::class] = function (Container $c) {
            return new Commands\ServeCommand($c[Server::class]);
        };

        $app[Commands\Make\MakeControllerCommand::class] = function (Container $c) {
            return new Commands\Make\MakeControllerCommand(
                $c[Config::class],
                $c[Creator::class],
                $c[Filesystem::class],
            );
        };

        $app[Commands\Make\MakeCommandCommand::class] = function (Container $c) {
            return new Commands\Make\MakeCommandCommand(
                $c[Config::class],
                $c[Creator::class],
                $c[Filesystem::class],
            );
        };

        $app[Commands\Make\MakeMiddlewareCommand::class] = function (Container $c) {
            return new Commands\Make\MakeMiddlewareCommand(
                $c[Config::class],
                $c[Creator::class],
                $c[Filesystem::class],
            );
        };
    }
}
