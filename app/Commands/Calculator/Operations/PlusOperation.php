<?php

declare(strict_types=1);

namespace App\Commands\Calculator\Operations;

class PlusOperation implements OperationInterface
{

    public function calculate(float $firstNum, float $secondNum): float
    {
        return $firstNum + $secondNum;
    }
}
