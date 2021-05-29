<?php
namespace Eddy\Framework\Core;

use Eddy\Framework\Bootstrap\InitConfigFromPath;
use Eddy\Framework\Support\Traits\General\CanBecomeJson;

class Config implements \ArrayAccess, \Serializable, \JsonSerializable
{
    use CanBecomeJson;

    public function __construct(private array $values = [])
    {}

    private function resolveRecursively(string $key, array $values)
    {
        $bits = explode('.', $key);

        foreach ($bits as $bit) {
            $values = $this->resolveFrom($bit, $values);

            if (!is_array($values)) {
                return $values;
            }
        }

        return $values;
    }

    private function resolveFrom(
        string $key,
        array $values = []
    ) {
        !empty($values) ?: $values = &$this->values;

        if (array_key_exists($key, $values)) {
            return $values[$key];
        }

        if (strpos($key, '.') !== false) {
            return $this->resolveRecursively($key, $values);
        }

        return null;
    }

    public function get(string $key = null)
    {
        if ($key === null) {
            return $this->values;
        }
        // resolve nested keys
        return $this->resolveFrom($key);
    }

    public function has(string $key)
    {
        // TODO check keys properly
        return $this->resolveFrom($key) !== null;
    }

    public function offsetExists($offset)
    {
        return $this->has($offset);
    }
    
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    public function offsetSet($offset, $value)
    {
        // does nothing
    }

    public function offsetUnset($offset)
    {
        // does nothing
    }

    public function serialize()
    {
        return serialize($this->values);
    }

    public function unserialize($serialized)
    {
        $this->values = unserialize($serialized);
    }

    public function toArray(): array
    {
        return $this->values;
    }

    public static function fromDir(string $dir): Config
    {
        return (new InitConfigFromPath($dir))->load();
    }
}
