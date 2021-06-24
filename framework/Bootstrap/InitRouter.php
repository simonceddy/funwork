<?php
namespace Eddy\Framework\Bootstrap;

use Eddy\Config\SafeInclude;
use FastRoute\RouteCollector;

class InitRouter
{
    public function register(RouteCollector $routes)
    {
        if (file_exists($apiRoutes = projectDir() . '/routes/api.php')) {
            $apiCallback = SafeInclude::file($apiRoutes);
            $routes->addGroup('/api', $apiCallback);
        }
        if (file_exists($webRoutes = projectDir() . '/routes/web.php')) {
            $webCallback = SafeInclude::file($webRoutes);
            call_user_func($webCallback, $routes);
        }
        return $routes;
    }
}
