<?php

declare(strict_types=1);

namespace App\Commands\Calculator\Services;

use App\Commands\Calculator\Factories\OperationFactory;
use Symfony\Component\Console\Input\InputInterface;

class CalculatorService
{
    public function __construct(private OperationFactory $operationFactory)
    {
    }

    public function execute(InputInterface $input): float
    {
        $firstNum = (float)$input->getArgument('firstNum');
        $secondNum = (float)$input->getArgument('secondNum');
        $operation = $input->getArgument('operation');

        $operation = $this->operationFactory->getOperation($operation);

        return $operation->calculate($firstNum, $secondNum);
    }
}
