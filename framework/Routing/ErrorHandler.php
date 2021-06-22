<?php
namespace Eddy\Framework\Routing;

use Eddy\Framework\Http\Messages\JsonResponse;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use React\Http\Message\Response;

final class ErrorHandler
{
    public function __construct(private ? LoggerInterface $logger = null)
    {}

    public function __invoke(ServerRequestInterface $request, callable $next)
    {
        try {
            return $next($request);
        } catch (\Throwable $error) {
            if (isset($this->logger)) {
                $this->logger->error((string) $error);
            }

            return JsonResponse::internalServerError(
                $error->getMessage()
            );
        }
    }
}
