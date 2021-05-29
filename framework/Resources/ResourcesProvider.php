<?php
namespace Eddy\Framework\Resources;

use Eddy\Coder\{
    Creator,
    TemplateManager,
    Templator
};
use Pimple\{
    Container,
    ServiceProviderInterface
};
use Symfony\Component\Filesystem\Filesystem;

class ResourcesProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app[TemplateManager::class] = function (Container $c) {
            return new TemplateManager(
                $c[Filesystem::class],
                __DIR__ . '/templates'
            );
        };

        $app[Templator::class] = function () {
            return new Templator();
        };

        $app[Creator::class] = function (Container $c) {
            return new Creator(
                $c[TemplateManager::class],
                $c[Templator::class]
            );
        };
    }
}
