<?php
namespace Eddy\Framework\Database;

use Eddy\Config\Config;
use Pimple\{
    Container,
    ServiceProviderInterface
};

class DatabaseProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        if (!isset($app[Config::class])) {
            return $app;
        }

        (new BindDbalConnections())->bindFromConfig($app[Config::class], $app);
    }
}
