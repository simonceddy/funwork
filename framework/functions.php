<?php
if (!function_exists('env')) {
    /**
     * Get a value from the local environment.
     * 
     * If the given key is not found it will return any provided default
     * value.
     *
     * @param string $key The key to search the environment for
     * @param mixed $default The optional default value
     *
     * @return mixed Returns either the value of the given key or the default
     */
    function env(string $key, $default = null) {
        return getenv($key) ?: $default;
    }
}

if (!function_exists('projectDir')) {
    /**
     * Get the path to the projects root directory.
     *
     * @return string The path to the project root as a string.
     */
    function projectDir(): string {
        $dir = dirname(__DIR__);

        while (!file_exists($dir . '/vendor/autoload.php')
            && !file_exists($dir . '/composer.json')
            && $dir !== ($newDir = dirname($dir))
        ) {
            $dir = $newDir;
        }

        return $dir;
    }
}
