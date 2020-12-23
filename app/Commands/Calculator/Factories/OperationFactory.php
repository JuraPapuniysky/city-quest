<?php

declare(strict_types=1);

namespace App\Commands\Calculator\Factories;

use App\Commands\Calculator\Operations\MinusOperation;
use App\Commands\Calculator\Operations\OperationInterface;
use App\Commands\Calculator\Operations\PlusOperation;
use DI\NotFoundException;

class OperationFactory
{
    private array $operations = [
        '+' => PlusOperation::class,
        '-' => MinusOperation::class,
    ];

    public function getOperation(string $operationSymbol): OperationInterface
    {
        if (array_key_exists($operationSymbol, $this->operations) === false) {
            throw new NotFoundException('Operation not found');
        }

        return new $this->operations[$operationSymbol];
    }
}
