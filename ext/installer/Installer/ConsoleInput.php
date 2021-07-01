<?php
namespace Eddy\Framework\Installer;

use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;

/**
 * Wrapper around a Symfony\Console input object
 * 
 * @method string|null getFirstArgument()
 * @method bool hasParameterOption($values, bool $onlyParams = false)
 * @method mixed getParameterOption($values, $default = false, bool $onlyParams = false)
 * @method void bind(InputDefinition $definition)
 * @method void validate()
 * @method array getArguments()
 * @method string|string[]|null getArgument(string $name)
 * @method void setArgument(string $name, $value)
 * @method bool hasArgument($name)
 * @method array getOptions()
 * @method string|string[]|bool|null getOption(string $name)
 * @method void setOption(string $name, $value)
 * @method bool hasOption(string $name)
 * @method bool isInteractive()
 * @method void setInteractive(bool $interactive)
 */
class ConsoleInput
{
    private function __construct(private InputInterface $input)
    {}

    public function __call(string $name, array $args)
    {
        if (method_exists($this->input, $name)) {
            return call_user_func_array([$this->input, $name], $args);
        }

        throw new \BadMethodCallException(
            'Unknown method: ' . $name
        );
    }

    /**
     * Factory for creating a new ConsoleInput wrapper with the appropriate
     * InputDefinition
     *
     * @return ConsoleInput
     */
    public static function fetch()
    {
        return new self(
            new ArgvInput(null, new InputDefinition([
                new InputArgument(
                    'name',
                    InputArgument::REQUIRED,
                    'The name of the fresh new app to create.'
                )
            ]))
        );
    }
}
