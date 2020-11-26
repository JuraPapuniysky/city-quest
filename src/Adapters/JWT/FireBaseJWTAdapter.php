<?php

declare(strict_types=1);

namespace PsrFramework\Adapters\JWT;

use Firebase\JWT\JWT;

class FireBaseJWTAdapter implements JWTInterface
{
    private int $accessTokenLifetime;

    private int $refreshTokenLifetime;

    private array $payload;

    private string $key;

    public function __construct(string $key, array $payload, int $accessTokenLifetime, int $refreshTokenLifetime)
    {
        $this->key = $key;
        $this->payload = $payload;
        $this->accessTokenLifetime = $accessTokenLifetime;
        $this->refreshTokenLifetime = $refreshTokenLifetime;
    }

    public function encodeAccessToken(array $data = [], $algorithm = 'HS256'): string
    {
        $this->payload['data'] = $data;
        $currentTime = time();
        $this->payload['exp'] = $currentTime + $this->accessTokenLifetime;
        $this->payload['nbf'] = $currentTime;

        return JWT::encode($this->payload, $this->key, $algorithm);
    }

    public function encodeRefreshToken(array $data = [], $algorithm = 'HS256'): string
    {
        $this->payload['data'] = $data;
        $currentTime = time();
        $this->payload['exp'] = $currentTime + $this->refreshTokenLifetime;
        $this->payload['nbf'] = $currentTime;

        return JWT::encode($this->payload, $this->key, $algorithm);
    }

    public function decode(string $jwt, array $algorithm = ['HS256'])
    {
        return JWT::decode($jwt, $this->key, $algorithm);
    }
}
