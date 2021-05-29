<?php
namespace Eddy\Framework\Routing;

// use FastRoute\Dispatcher;
use FastRoute\RouteCollector;

/**
 * Basic wrapper for FastRoute's RouteCollector
 * 
 * @method void addRoute($httpMethod, $route, $handler) Add a route to the RouteCollector
 * @method void addGroup($prefix, callable $callback) Add a route group
 * @method void get($route, $handler) Add a get route
 * @method void post($route, $handler) Add a post route
 * @method void put($route, $handler) Add a put route
 * @method void delete($route, $handler) Add a delete route
 * @method void patch($route, $handler) Add a patch route
 * @method void head($route, $handler) Add a head route
 * @method array getData() Returns the collected route data
 */
class Routes
{
    public function __construct(private RouteCollector $fastRoutes)
    {

    }

    public function __call(string $name, array $arguments)
    {
        if (method_exists($this->fastRoutes, $name)) {
            return call_user_func_array(
                [$this->fastRoutes, $name],
                $arguments
            );
        }

        throw new \BadMethodCallException("Undefined method: {$name}");
    }

    /**
     * Get the underlying RouteCollector instance
     * 
     * @return RouteCollector
     */ 
    public function routeCollector()
    {
        return $this->fastRoutes;
    }
}
