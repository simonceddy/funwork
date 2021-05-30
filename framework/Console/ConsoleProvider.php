<?php
namespace Eddy\Framework\Console;

use Eddy\Framework\{
    Core\Config,
};
use Pimple\{
    Container,
    ServiceProviderInterface
};
use Symfony\Component\Console\Application;
use Symfony\Component\Console\CommandLoader\CommandLoaderInterface;

class ConsoleProvider implements ServiceProviderInterface
{
    
    public function register(Container $app)
    {
        $app->register(new CommandProvider());
        
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
