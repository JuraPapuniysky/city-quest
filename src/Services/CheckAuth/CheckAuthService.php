<?php

declare(strict_types=1);

namespace PsrFramework\Services\CheckAuth;

use App\Exceptions\AuthException;
use Psr\Http\Message\ServerRequestInterface;

class CheckAuthService implements CheckAuthInterface
{
    public function checkIdentity(ServerRequestInterface $request): IdentityInterface
    {
        $user = $request->getAttribute('authUserEntity');
        if ($user instanceof IdentityInterface) {
            return $user;
        }

        throw new AuthException($request->getAttribute('authError'), 412);
    }
}
