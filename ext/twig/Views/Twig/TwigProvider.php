<?php
namespace Eddy\Framework\Views\Twig;

use Eddy\Config\Config;
use Pimple\{
    Container,
    ServiceProviderInterface
};
use Twig\Environment;
use Twig\Loader\{
    FilesystemLoader,
    LoaderInterface
};

class TwigProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        if (!isset($app[LoaderInterface::class])) {
            $app[LoaderInterface::class] = function (Container $c) {
                return new FilesystemLoader(
                    $c[Config::class]['twig.path']
                );
            };
        }

        $app[Environment::class] = function (Container $c) {
            return new Environment(
                $c[LoaderInterface::class],
                $c[Config::class]['twig.options']
            );
        };

        $app['twig'] = function (Container $c) {
            return $c[Environment::class];
        };
    }
}
