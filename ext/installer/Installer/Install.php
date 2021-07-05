<?php
namespace Eddy\Framework\Installer;

use Symfony\Component\Filesystem\Filesystem;

class Install
{
    public static function fresh(string $name, array $options = [])
    {
        dump(getcwd());
        $dir = getcwd() . DIRECTORY_SEPARATOR . $name;

        if (is_dir($dir)) {
            dd(scandir($dir));
        }
        # code...

        $installer = new Installer(new Filesystem());
    }
}
