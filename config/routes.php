<?php

/** @var \PsrFramework\Http\Application $app */

//HelloController routes
$app->get('hello', '/api/v1/hello/{name}', [\App\Controllers\HelloController::class, 'index']);
$app->post('hello_post', '/api/v1/hello/post', [\App\Controllers\HelloController::class, 'post']);
$app->post('hello_error', '/api/v1/hello/error', [\App\Controllers\HelloController::class, 'error']);

//AuthController routes
$app->post('registration', '/api/v1/auth/registration', [\App\Controllers\AuthController::class, 'registration']);
$app->put('confirmUser', '/api/v1/auth/confirm/{confirmToken}', [\App\Controllers\AuthController::class, 'confirm']);
$app->post('auth', '/api/v1/auth', [\App\Controllers\AuthController::class, 'auth']);
$app->post('checkAccessToken', '/api/v1/auth/check', [\App\Controllers\AuthController::class, 'checkAccessToken']);
$app->post('refreshAuth', '/api/v1/auth/refresh', [\App\Controllers\AuthController::class, 'refresh']);

require_once __DIR__.'/../geo/routes.php';
require_once __DIR__.'/../quest/routes.php';
