<?php
namespace Eddy\Framework\Core;

use Eddy\Config\Config;
use Eddy\Framework\{
    Bootstrap\InitApplication
};
use Eddy\Framework\Support\Traits\General\HasArrayAccess;
use Pimple\{
    Container,
    ServiceProviderInterface
};
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;

/**
 * The Kernel class is the central app object of the framework.
 * 
 * It is a PSR-11 wrapper for the pimple container, as well as being aware of
 * application config, and providing some extra helper methods.
 */
class Kernel implements ContainerInterface,
LoggerAwareInterface,
LoggerInterface,
\ArrayAccess
{
    use HasArrayAccess;
    use LoggerAwareTrait;
    use LoggerTrait;

    private bool $console = false;

    private bool $loggingEnabled = true;

    private function __construct(
        private Container $pimple,
        private Config $config
    ) {
        $this->preboot();
        $this->bindSelfToContainer();
        $this->bootCoreServices();
        $this->bootApplication();
    }

    private function preboot()
    {
        $this->loggingEnabled = $this->config['logs.disabled'] !== true;

        if (defined('STDIN') && php_sapi_name() === 'cli') {
            $this->console = true;
        }
    }

    private function bindSelfToContainer()
    {
        if (!isset($this->pimple[Config::class])) {
            $this->pimple[Config::class] = fn() => $this->config;
        }
        if (!isset($this->pimple[Kernel::class])) {
            $this->pimple[Kernel::class] = fn() => $this;
        }
    }

    private function bootCoreServices()
    {
        $this->pimple->register(new Providers\CoreProvider());
    }

    private function bootApplication()
    {
        (new InitApplication())->boot($this);
    }

    /**
     * Get the given id from the pimple container
     *
     * @param string $id
     *
     * @return mixed
     */
    public function get(string $id)
    {
        return $this->pimple->offsetGet($id);
    }

    /**
     * Check if the given id is set in the pimple container
     *
     * @param string $id
     *
     * @return bool
     */
    public function has(string $id): bool
    {
        return $this->pimple->offsetExists($id);
    }

    /**
     * Set a binding in the pimple container
     *
     * @param string|mixed $key
     * @param mixed $value
     *
     * @return void
     */
    public function set($key, $value)
    {
        $this->pimple->offsetSet($key, $value);
    }

    /**
     * Removes the given key from the pimple container.
     *
     * @param mixed $offset
     *
     * @return void
     */
    public function destroy($offset)
    {
        $this->pimple->offsetUnset($offset);
    }

    /**
     * Returns the config value for the given key, or, if no key is provided,
     * it will return the Kernel's config object.
     *
     * @param string|null $key An optional config key to fetch
     *
     * @return mixed|Config
     */
    public function config(string $key = null)
    {
        return $key === null ? $this->config : $this->config->get($key);
    }

    /**
     * Get the wrapped Pimple container.
     * 
     * This method returns the unwrapped Pimple container without a PSR-11
     * wrapper. Pimple does not implement PSR-11 itself, and will not work
     * with functions expecting a PSR-11 container without a wrapper.
     *
     * @return Container
     */
    public function pimple()
    {
        return $this->pimple;
    }

    public function register(ServiceProviderInterface $provider)
    {
        $this->pimple->register($provider);
    }

    /**
     * Is the app running from the command line
     *
     * @return bool
     */
    public function runningInConsole(): bool
    {
        return $this->console;
    }

    /**
     * Is application logging enabled
     *
     * @return bool
     */
    public function loggingEnabled()
    {
        return $this->loggingEnabled;
    }

    public function log($level, $message, array $context = array())
    {
        if (isset($this->logger)) {
            $this->logger->log($level, $message, $context);
        }
    }

    /**
     * Static factory for creating a new Kernel
     *
     * @param string|null $projectDir If null the function will attempt to
     * auto-resolve the project root dir.
     *
     * @return Kernel The newly minted and booted fresh Kernel instance
     */
    public static function create(string $projectDir = null): Kernel
    {
        $dir = $projectDir ?? projectDir();
        $config = Config::fromPath($dir . '/config');
        return new static(
            new Container(),
            $config
        );
    }
}
