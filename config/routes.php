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

//Country controller
$app->get('country', '/api/v1/country/{uuid}', [\App\Controllers\CountryController::class, 'country'], true);
$app->get('countries', '/api/v1/countries', [\App\Controllers\CountryController::class, 'countries'], true);
$app->post('countryCreate', '/api/v1/country', [\App\Controllers\CountryController::class, 'create'], true);
$app->put('countryUpdate', '/api/v1/country/{uuid}', [\App\Controllers\CountryController::class, 'update'], true);
$app->delete('countryDelete', '/api/v1/country/{uuid}', [\App\Controllers\CountryController::class, 'delete'], true);

//CityController
$app->get('city', '/api/v1/city/{uuid}', [\App\Controllers\CityController::class, 'city'], true);
$app->get('cities', '/api/v1/cities/{countryUuid}', [\App\Controllers\CityController::class, 'cities'], true);
$app->post('cityCreate', '/api/v1/city', [\App\Controllers\CityController::class, 'create'], true);
$app->put('cityUpdate', '/api/v1/city/{uuid}', [\App\Controllers\CityController::class, 'update'], true);
$app->delete('cityDelete', '/api/v1/city/{uuid}', [\App\Controllers\CityController::class, 'delete'], true);

//QuestController
$app->get('quest', '/api/v1/quest/{uuid}', [\App\Controllers\QuestController::class, 'quest'], true);
$app->get('quests', '/api/v1/quests/{countryUuid}', [\App\Controllers\QuestController::class, 'quests'], true);
$app->post('questCreate', '/api/v1/quest', [\App\Controllers\QuestController::class, 'create'], true);
$app->put('questUpdate', '/api/v1/quest/{uuid}', [\App\Controllers\QuestController::class, 'update'], true);
$app->delete('questDelete', '/api/v1/quest/{uuid}', [\App\Controllers\QuestController::class, 'delete'], true);

//QuestQuestionController
$app->get('questQuestion', '/api/v1/question/{uuid}', [\App\Controllers\QuestQuestionController::class, 'question'], true);
$app->get('quests', '/api/v1/questions/{questUuid}', [\App\Controllers\QuestQuestionController::class, 'questions'], true);
$app->post('questionCreate', '/api/v1/question', [\App\Controllers\QuestQuestionController::class, 'create'], true);
$app->put('questionUpdate', '/api/v1/question/{uuid}', [\App\Controllers\QuestQuestionController::class, 'update'],true);
$app->delete('questionDelete', '/api/v1/question/{uuid}', [\App\Controllers\QuestQuestionController::class, 'delete'], true);
