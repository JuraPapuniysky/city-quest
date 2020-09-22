<?php
return[
    'payload' => [
        "iss" => $_ENV['JWT_ISS'],
        "aud" => $_ENV['JWT_AUD'],
    ],
    'key' => $_ENV['JWT_KEY'],
    'accessTokenLifetime' => $_ENV['JWT_ACCESS_TOKEN_LIFETIME'],
    'refreshTokenLifetime' => $_ENV['JWT_REFRESH_TOKEN_LIFETIME'],
];