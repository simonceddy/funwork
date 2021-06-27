<?php
namespace Eddy\Framework\Setup;

use Symfony\Component\Filesystem\Filesystem;

class SetUp
{
    private Filesystem $fs;

    private string $packageDir;

    private array $pathsToCopy = [
        'config',
        'routes',
        'bootstrap'
    ];

    private function __construct(private string $projectDir)
    {
        $this->fs = new Filesystem();
        $this->packageDir = dirname(__DIR__, 2);
    }

    private function copyFromTo(string $srcPath, string $targetPath)
    {
        if (!$this->fs->exists($srcPath)) {
            throw new \Exception(
                'Could not find source: ' . $srcPath
            );
        }
        
        if ($this->fs->exists($targetPath)) {
            echo $targetPath . ' exists. Skipping...' . PHP_EOL;
            return 0;
        }

        $call = [$this->fs, is_dir($srcPath) ? 'mirror' : 'copy'];
        
        try {
            call_user_func($call, $srcPath, $targetPath);
        } catch (\Throwable $e) {
            throw $e;
        }

        return 1;
    }

    public function runSetup(array $options = [])
    {
        foreach ($this->pathsToCopy as $path) {
            $this->copyFromTo(
                $this->packageDir . '/' . $path,
                $this->projectDir . '/' . $path
            );
        }
    }

    public static function run(string $projectDir, array $options = [])
    {
        if (!is_dir($projectDir)) {
            echo 'Could not find project directory!' . PHP_EOL;
            return 0;
        }

        if (self::isSetUp($projectDir)) {
            echo 'App is already setup!' . PHP_EOL;
            return 0;
        }

        $setUp = new self($projectDir);

        try {
            echo 'Setting up framework boilerplate...' . PHP_EOL;
            $setUp->runSetup();
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public static function isSetUp(string $projectDir): bool
    {
        return is_dir($projectDir . '/config')
            && file_exists($projectDir . '/bootstrap/app.php');
    }
}
