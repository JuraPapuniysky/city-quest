<?php

/** @var \PsrFramework\Http\Application $app */

//HelloController routes
$app->get('hello', '/api/v1/hello/{name}', [\App\Controllers\HelloController::class, 'index']);
$app->post('hello_post', '/api/v1/hello/post', [\App\Controllers\HelloController::class, 'post']);
$app->post('hello_error', '/api/v1/hello/error', [\App\Controllers\HelloController::class, 'error']);

//AuthController routes
$app->post('registration', '/api/v1/auth/registration', [\App\Controllers\AuthController::class, 'registration']);
$app->post('auth', '/api/v1/auth', [\App\Controllers\AuthController::class, 'auth']);