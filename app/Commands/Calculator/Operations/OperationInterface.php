<?php

declare(strict_types=1);

namespace App\Commands\Calculator\Operations;

interface OperationInterface
{
    public function calculate(float $firstNum, float $secondNum): float;
}
