<?php

declare(strict_types=1);

namespace PsrFramework\Factories;

use PsrFramework\Services\CheckAuth\CheckAuthInterface;
use PsrFramework\Services\CheckAuth\CheckAuthService;

class CheckAuthServiceFactory
{
    public function __invoke(): CheckAuthInterface
    {
        return new CheckAuthService();
    }
}
