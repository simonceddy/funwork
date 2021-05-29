<?php
namespace Eddy\Framework\Console\Commands;

use Eddy\Framework\Server\Server;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ServeCommand extends Command
{
    public function __construct(private Server $server)
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('serve')
            ->setDescription('Starts a reactphp server');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('<info>Starting server...</info>');
        $output->writeln('Listening at ' . $this->server->httpAddress());

        $this->server->run();
    }
}
