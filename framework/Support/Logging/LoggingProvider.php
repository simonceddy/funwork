<?php
namespace Eddy\Framework\Support\Logging;

use Eddy\Framework\Core\Config;
use Eddy\RefCon\ReflectionConstructor;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Pimple\{
    Container,
    ServiceProviderInterface
};

class LoggingProvider implements ServiceProviderInterface
{
    private function registerHandler($handler, Container $app, array $args)
    {
        $app[$handler] = fn() => new $handler(...$args);
    }

    private function registerHandlersFromConfig(
        Config $config,
        Container $app
    ) {
        $handlers = $config['logs.handlers'];
        // dd($handlers);
        if (!empty($handlers)) {
            foreach ($handlers as $handler => $args) {
                $this->registerHandler($handler, $app, $args);
            }
        }
    }

    private function buildLogger(
        string $name,
        array $handlers,
        Container $app
    ) {
        $logger = new Logger($name);
        // dd($handlers);
        /**
         * @var ReflectionConstructor
         */
        $refcon = $app[ReflectionConstructor::class];

        foreach ($handlers as $handler) {
            if (isset($app[$handler])) {
                $logger->pushHandler($app[$handler]);
                continue;
            }
            try {
                $logger->pushHandler($refcon->create($handler));
            } catch (\Throwable $e) {
                throw $e;
            }
        }

        return $logger;
    }

    public function register(Container $app)
    {
        if (isset($app[Config::class])) {

            $this->registerHandlersFromConfig($app[Config::class], $app);
    
            $loggers = $app[Config::class]['logs.loggers'];

            foreach ($loggers as $logger => $handlers) {
                $app['logger.' . $logger] = function (Container $c) use ($logger, $handlers)
                {
                    return $this->buildLogger(
                        $logger,
                        $handlers,
                        $c
                    );
                };
            }
        }
    }
}
