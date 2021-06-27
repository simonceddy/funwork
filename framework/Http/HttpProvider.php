<?php
namespace Eddy\Framework\Http;

use Laminas\Diactoros\{
    Request,
    Response,
    ServerRequestFactory,
    ResponseFactory
};
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use Pimple\{
    Container,
    ServiceProviderInterface
};

class HttpProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app[Request::class] = function () {
            return ServerRequestFactory::fromGlobals(
                $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES
            );
        };

        $app[Response::class] = function () {
            return new Response();
        };

        $app[ResponseFactory::class] = function () {
            return new ResponseFactory();
        };

        $app[SapiEmitter::class] = function (Container $c) {
            return new SapiEmitter();
        };
    }
}
