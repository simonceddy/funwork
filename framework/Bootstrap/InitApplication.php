<?php
namespace Eddy\Framework\Bootstrap;

use Eddy\Framework\Core\Kernel;

class InitApplication
{
    private function bootProvider(Kernel $kernel, $provider)
    {
        if (is_string($provider) && class_exists($provider)) {
            try {
                $kernel->register(new $provider());
            } catch (\Throwable $e) {
                // Handle error
                throw $e;
            } 
        }
    }

    private function bootProviders(Kernel $kernel, array $providers)
    {
        foreach ($providers as $index => $provider) {
            $this->bootProvider($kernel, $provider);
        }
    }

    public function boot(Kernel $kernel)
    {
        $config = $kernel->config();

        $providers = $config['app.providers'];

        if (!empty($providers)) {
            $this->bootProviders($kernel, $providers);
        }

        return $kernel;
    }
}
