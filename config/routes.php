<?php

/** @var \PsrFramework\Http\Application $app */

//HelloController routes
$app->get('hello', '/api/v1/hello/{name}', [\App\Controllers\HelloController::class, 'index']);
$app->post('hello_post', '/api/v1/hello/post', [\App\Controllers\HelloController::class, 'post']);
$app->post('hello_error', '/api/v1/hello/error', [\App\Controllers\HelloController::class, 'error']);

//AuthController routes
$app->post('registration', '/api/v1/auth/registration', [\App\Controllers\AuthController::class, 'registration']);
$app->post('auth', '/api/v1/auth', [\App\Controllers\AuthController::class, 'auth']);

//Country controller
$app->get('country', '/api/v1/country/{uuid}', [\App\Controllers\CountryController::class, 'country']);
$app->get('countries', '/api/v1/countries', [\App\Controllers\CountryController::class, 'countries']);
$app->post('countryCreate', '/api/v1/country', [\App\Controllers\CountryController::class, 'create']);
$app->put('countryUpdate', '/api/v1/country/{uuid}', [\App\Controllers\CountryController::class, 'update']);
$app->delete('countryDelete', '/api/v1/country/{uuid}', [\App\Controllers\CountryController::class, 'delete']);

