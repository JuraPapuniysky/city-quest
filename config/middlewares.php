<?php
/** @var \PsrFramework\Http\Application $app */

$app->pipe(\App\Middlewares\CORSMiddleware::class);
$app->pipe(\App\Middlewares\ErrorMiddleware::class);
$app->pipe(\App\Middlewares\BodyParamsMiddleware::class);
$app->pipe(\App\Middlewares\JwtAuthMiddleware::class);
$app->pipe(\App\Middlewares\CredentialsMiddleware::class);
$app->pipe(\PsrFramework\Http\Router\Router::class);

