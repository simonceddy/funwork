<?php
namespace Eddy\Framework\Routing;

use Eddy\RefCon\ReflectionConstructor;
use Pimple\Container;

class ControllerResolver
{
    public function __construct(
        private Container $app,
        private ReflectionConstructor $refCon
    ) {}

    private function resolveControllerClass(string $controller)
    {
        if (isset($this->app[$controller])) {
            return $this->app[$controller];
        }

        if (class_exists($controller)) {
            return $this->refCon->create($controller);
        }

        throw new \InvalidArgumentException('Invalid controller class');
    }

    /**
     * Resolve a controller
     *
     * @param string|callback $controller
     *
     * @return void
     */
    public function resolve($controller)
    {
        if (is_callable($controller)) {
            return $controller;
        }

        if (is_string($controller)) {
            return $this->resolveControllerClass($controller);
        }

        throw new \LogicException(
            'Invalid controller provided.'
        );
    }
}
