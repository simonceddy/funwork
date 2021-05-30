<?php
namespace App\Console\Commands;

use Symfony\Component\Console\{
    Command\Command,
    Input\InputInterface,
    Output\OutputInterface
};

class MyCommand extends Command
{
    protected function configure()
    {
        // Configure command here
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Run command here
        return 0;
    }
}
