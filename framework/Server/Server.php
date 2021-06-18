<?php
namespace Eddy\Framework\Server;

use React\EventLoop\LoopInterface;
use React\Http\Server as HttpServer;
use React\Socket\Server as SocketServer;

class Server
{
    public function __construct(
        private LoopInterface $loop,
        private HttpServer $httpServer, 
        private SocketServer $socketServer
    ) {}

    public function on($event, callable $listener)
    {
        return $this->httpServer->on($event, $listener);
    }

    public function once($event, callable $listener)
    {
        return $this->httpServer->once($event, $listener);
    }

    public function removeAllListeners($event = null)
    {
        return $this->httpServer->removeAllListeners($event);
    }
    
    public function removeListener($event, callable $listener)
    {
        return $this->httpServer->removeListener($event, $listener);
    }

    public function emit($event, array $arguments = [])
    {
        return $this->httpServer->emit($event, $arguments);
    }

    public function listeners($event = null)
    {
        return $this->httpServer->listeners($event);
    }

    public function pause()
    {
        $this->socketServer->pause();
    }

    public function resume()
    {
        $this->socketServer->resume();
    }

    public function close()
    {
        $this->socketServer->close();
    }

    public function getAddress()
    {
        return $this->socketServer->getAddress();
    }

    public function httpAddress()
    {
        return str_replace('tcp', 'http', $this->getAddress());
    }
    public function run()
    {
        $this->httpServer->listen($this->socketServer);
        $this->loop->run();
    }
}
