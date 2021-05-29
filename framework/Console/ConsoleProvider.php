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
use Symfony\Component\Console\Application;
use Symfony\Component\Console\CommandLoader\CommandLoaderInterface;
use Symfony\Component\Filesystem\Filesystem;

class ConsoleProvider implements ServiceProviderInterface
{
    private function registerCommands(Container $app)
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
    }

    public function register(Container $app)
    {
        $this->registerCommands($app);
        
        $app[CommandLoaderInterface::class] = function (Container $c) {
            return new CommandLoader($c);
        };

        $app[Application::class] = function (Container $c) {
            $cli = new Application(
                $c[Config::class]['app.name'],
                $c[Config::class]['app.version'],
            );

            $cli->setCommandLoader($c[CommandLoaderInterface::class]);
            return $cli;
        };

    }
}
