<?php
namespace Eddy\Framework\Console\Commands\Make;

use Eddy\Coder\Creator;
use Eddy\Coder\PhpResource;
use Eddy\Config\Config;
use Eddy\Framework\Filesystem\Filesystem;
use Symfony\Component\Console\{
    Command\Command,
    Input\InputArgument,
    Input\InputInterface,
    Output\OutputInterface
};
use Symfony\Component\Console\Input\InputOption;

class MakeControllerCommand extends Command
{
    public function __construct(
        private Config $config,
        private Creator $creator,
        private Filesystem $fs,
    )
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('make:controller')
            ->setDescription('Creates a new controller class')
            ->addArgument(
                'name',
                InputArgument::REQUIRED,
                'The name of the controller'
            )
            ->addOption(
                'force',
                'F',
                InputOption::VALUE_NONE,
                'Force overwriting existing files.'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('name');

        $ns = $this->config['app.namespace'] . '\\Http\\Controllers';

        if (strpos($name, '/')) {
            $bits = explode('/', $name);
            $name = array_pop($bits);
            $ns = $ns . '\\' . implode('\\', $bits);
        }

        $force = $input->getOption('force');

        $resource = new PhpResource($name, $ns, projectDir() . '/src');

        $result = $this->creator->create($resource, 'controller');
       
        $fn = $result->getPath();

        if (!$force && $this->fs->exists($fn)) {
            $output->writeln('<error>File already exists!</error>');
            $output->writeln('Use the force (Luke) option (<info>--force OR -F</info>) to force overwriting exisitng files');

            return 0;
        }

        try {
            $this->fs->dumpFile($fn, $result);
        } catch (\Throwable $e) {
            $output->writeln(
                '<error>Encountered an error: ' . $e->getMessage() . '</error>'
            );
        }
        
        $output->writeln(
            '<info>Successfully created controller at ' . $fn . '</info>'
        );
        
        return 0;
    }
}
