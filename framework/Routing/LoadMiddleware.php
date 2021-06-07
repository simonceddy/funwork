<?php
namespace Eddy\Framework\Routing;

use Eddy\RefCon\ReflectionConstructor;

class LoadMiddleware
{
    public function __construct(
        private ReflectionConstructor $refcon,
        private array $middlewares = [],
    ) {}

    public function load()
    {
        $loaded = [];
        foreach ($this->middlewares as $mw) {
            if (is_callable($mw)) {
                $loaded[] = $mw;
            } elseif (is_string($mw)) {
                $loaded[] = $this->refcon->create($mw);
            } else {
                throw new \InvalidArgumentException(
                    'Invalid middleware!'
                );
            }
        }

        return $loaded;
    }
}
