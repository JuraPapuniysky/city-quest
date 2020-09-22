<?php

declare(strict_types=1);

namespace PsrFramework\Adapters\JWT;

interface JWTInterface
{
    public function encodeAccessToken(array $data = [], $algorithm = 'HS256'): string;

    public function encodeRefreshToken(array $data = [], $algorithm = 'HS256'): string;

    public function decode(string $jwt, array $algorithm = ['HS256']);
}