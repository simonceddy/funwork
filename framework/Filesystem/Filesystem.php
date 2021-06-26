<?php
namespace Eddy\Framework\Filesystem;

use React\EventLoop\LoopInterface;
use React\Filesystem\AdapterInterface;
use React\Filesystem\CallInvokerInterface;
use React\Filesystem\Filesystem as ReactFs;
use React\Filesystem\FilesystemInterface;
use React\Filesystem\Node\NodeInterface;
use Symfony\Component\Filesystem\Filesystem as SymfonyFs;

class Filesystem extends SymfonyFs implements FilesystemInterface
{
    private function __construct(
        private ReactFs $reactFs,
        private ? string $rootDir = null
    ) {}

    public function rootDir()
    {
        return $this->rootDir ?? false;
    }

    public static function create(LoopInterface $loop, array $options = [])
    {
        return new static(
            ReactFs::create($loop, $options),
            $options['rootDir'] ?? null
        );
    }

    public static function createFromAdapter(AdapterInterface $adapter)
    {
        return ReactFs::createFromAdapter($adapter);
    }

    public static function getSupportedAdapters()
    {
        return ReactFs::getSupportedAdapters();
    }

    public function getAdapter()
    {
        return $this->reactFs->getAdapter();
    }

    public function file($filename)
    {
        return $this->reactFs->file($filename);
    }

    public function dir($path)
    {
        return $this->reactFs->dir($path);
    }

    public function link($path, NodeInterface $destination)
    {
        return $this->reactFs->link($path, $destination);
    }

    public function getContents($filename)
    {
        return $this->reactFs->getContents($filename);
    }

    public function setInvoker(CallInvokerInterface $invoker)
    {
        return $this->reactFs->setInvoker($invoker);
    }

    public function __call($name, $arguments)
    {
        if (method_exists($this->reactFs, $name)) {
            return call_user_func_array([$this->reactFs, $name], $arguments);
        }

        throw new \BadMethodCallException(
            'Unknown method: ' . $name
        );
    }

    public static function make(ReactFs $reactFs)
    {
        return new static($reactFs);
    }
}
