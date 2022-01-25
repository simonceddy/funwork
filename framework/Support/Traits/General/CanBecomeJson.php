<?php
namespace Eddy\Framework\Support\Traits\General;

trait CanBecomeJson
{
    abstract public function toArray(): array;

    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }
}
