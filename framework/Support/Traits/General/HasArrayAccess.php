<?php
namespace Eddy\Framework\Support\Traits\General;

/**
 * Helper trait that forces wrapping ArrayAccess methods with less verbose
 * names.
 * 
 * @todo Change get and has so not to conflict with container?
 */
trait HasArrayAccess
{
    abstract public function get(string $id);

    abstract public function has(string $id): bool;

    abstract public function set($key, $value);

    abstract public function destroy($offset);

    public function offsetExists($offset): bool
    {
        return $this->has($offset);
    }

    public function offsetGet($offset): mixed
    {
        return $this->get($offset);
    }

    public function offsetSet($offset, $value): void
    {
        $this->set($offset, $value);
    }

    public function offsetUnset($offset): void
    {
        $this->destroy($offset);
    }
}
