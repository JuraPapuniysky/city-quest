<?php

declare(strict_types=1);

namespace App\Commands\Calculator\Operations;

class MinusOperation implements OperationInterface
{

    public function calculate(float $firstNum, float $secondNum): float
    {
        return $firstNum - $secondNum;
    }
}
