<?php
namespace App\Providers;

use Pimple\{
    Container,
    ServiceProviderInterface
};

class AppProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        // Register services here!
        $app['my_service'] = function () {
            return 'My Service!';
        };
    }
}
