<?php
namespace Eddy\Framework\Console;

use Pimple\Container;
use Symfony\Component\Console\CommandLoader\CommandLoaderInterface;
use Symfony\Component\Console\Exception\CommandNotFoundException;

class CommandLoader implements CommandLoaderInterface
{
    private array $commands = [
        'serve' => Commands\ServeCommand::class,
        'make:controller' => Commands\Make\MakeControllerCommand::class,
        'make:command' => Commands\Make\MakeCommandCommand::class,
        'make:middleware' => Commands\Make\MakeMiddlewareCommand::class,
    ];

    public function __construct(
        private Container $app,
        array $commands = []
    ) {
        if (!empty($commands)) {
            $this->commands = array_merge($this->commands, $commands);
        }
    }

    public function has(string $name)
    {
        return isset($this->commands[$name]);
    }

    public function get(string $name)
    {
        if (!$this->has($name)) {
            throw new CommandNotFoundException(
                'Unknown command: ' . $name
            );
        }

        return $this->app[$this->commands[$name]];
    }

    public function getNames()
    {
        return array_keys($this->commands);
    }
}
