<?php

declare(strict_types=1);

namespace App\Commands;

use App\Commands\Calculator\Services\CalculatorService;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CalculatorCommand extends Command
{
    protected static $defaultName = 'app:calculator-command';

    private CalculatorService $calculatorService;

    public function __construct(private ContainerInterface $container, $name = null)
    {
        $this->calculatorService = $this->container->get(CalculatorService::class);
        parent::__construct($name);
    }

    protected function configure()
    {
        $this->addArgument('firstNum', InputArgument::REQUIRED, 'First num');
        $this->addArgument('secondNum', InputArgument::REQUIRED, 'Second num');
        $this->addArgument('operation', InputArgument::REQUIRED, 'Operation');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $output->writeln($this->calculatorService->execute($input));
        } catch (\Throwable $e) {
            $output->writeln($e->getMessage());

            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
