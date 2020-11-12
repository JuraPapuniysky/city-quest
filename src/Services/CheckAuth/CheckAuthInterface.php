<?php

declare(strict_types=1);

namespace PsrFramework\Services\CheckAuth;

use Psr\Http\Message\ServerRequestInterface;

interface CheckAuthInterface
{
    public function checkIdentity(ServerRequestInterface $request): IdentityInterface;
}
