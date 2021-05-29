<?php
namespace Eddy\Framework\Routing;

use FastRoute\Dispatcher;
use Psr\Http\Message\ServerRequestInterface;
use React\Http\Message\Response;

class RouteDispatcher
{
    public function __construct(
        private Dispatcher $dispatcher,
        private ControllerResolver $resolver,
    ) {}

    public function dispatch(ServerRequestInterface $request)
    {
        $routeInfo = $this->dispatcher->dispatch(
            $request->getMethod(),
            $request->getUri()->getPath()
        );

        $result = $routeInfo[0];

        switch ($result) {
            case Dispatcher::NOT_FOUND:
                return new Response(
                    404,
                    ['Content-Type' => 'text/plain'],
                    'Not found'
                );
            case Dispatcher::METHOD_NOT_ALLOWED:
                return new Response( 405,
                    ['Content-Type' => 'text/plain',
                    'Method not allowed']
                );
            case Dispatcher::FOUND:
                $controller = $this->resolver->resolve($routeInfo[1]);
                return $controller($request);
        }

        throw new \LogicException(
            'Something went wrong with routing'
        );
    }

    public function __invoke(ServerRequestInterface $request)
    {
        return $this->dispatch($request);
    }
}
