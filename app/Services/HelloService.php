<?php

declare(strict_types=1);

namespace App\Services;

class HelloService
{
    public function sayHello(string $name): string
    {
        return "Hello $name";
    }
}