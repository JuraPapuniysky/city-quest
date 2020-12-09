<?php

declare(strict_types=1);

namespace App\Commands;

use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TestCommand extends Command
{
    protected static $defaultName = 'app:test-command';

    public function __construct(private ContainerInterface $container, $name = null)
    {
        parent::__construct($name);
    }

    protected function configure()
    {
        $this->addArgument('name', InputArgument::REQUIRED, 'Your name.');
        $this->addArgument('lastname', InputArgument::REQUIRED, 'Your lastname');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Hello ' . $input->getArgument('name') . ' ' . $input->getArgument('lastname'));

        return Command::SUCCESS;
    }
}
