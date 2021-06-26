<?php
namespace Eddy\Framework\Database;

use Doctrine\DBAL\Driver\Connection;
use Doctrine\DBAL\DriverManager;
use Eddy\Config\Config;
use Pimple\Container;

class BindDbalConnections
{
    private function getDriverFor(string $driver)
    {
        $driver = strtolower($driver);

        switch ($driver) {
            case 'mysql':
            case 'sqlite':
            case 'pgsql':
                return 'pdo_' . $driver;
            default:
                return $driver;
        }
    }

    /**
     * Prepare connection config
     *
     * @param string|array $config the dev provided connection settings 
     *
     * @return array Returns an array of config values
     * 
     * @throws \LogicException Thrown on invalid config
     */
    private function makeConnectionConfig($config)
    {
        if (is_array($config)) {
            $config['driver'] = isset($config['driver'])
                ? $this->getDriverFor($config['driver'])
                : 'pdo_mysql';
            return $config;
        }

        if (is_string($config)) return ['url' => $config];

        throw new \LogicException(
            'Invalid database config!'
        );
    }

    private function bindConnection(Container $app, string $name, array $config)
    {
        $app[$name] = fn() => DriverManager::getConnection($config);
    }

    private function bindDefaultConnection(Container $app, string $name)
    {
        $app[Connection::class] = fn(Container $c) => $c[$name];
    }

    public function bindFromConfig(Config $config, Container $app)
    {
        $connections = $config['database.connections'];

        if (!is_array($connections)) {
            return null;
        }

        foreach ($connections as $name => $conf) {
            $this->bindConnection(
                $app,
                'db.' . $name,
                $this->makeConnectionConfig($conf)
            );
        }

        if (count($connections) === 1) {
            $this->bindDefaultConnection(
                $app,
                'db.' . array_keys($connections)[0]
            );
        } else if (is_string($defaultConn = ($config['database.default']))) {
            $this->bindDefaultConnection($app, 'db.' . $defaultConn);
        }

        return $app;
    }
}
