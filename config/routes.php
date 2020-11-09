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

//CityController
$app->get('city', '/api/v1/city/{uuid}', [\App\Controllers\CityController::class, 'city']);
$app->get('cities', '/api/v1/cities/{countryUuid}', [\App\Controllers\CityController::class, 'cities']);
$app->post('cityCreate', '/api/v1/city', [\App\Controllers\CityController::class, 'create']);
$app->put('cityUpdate', '/api/v1/city/{uuid}', [\App\Controllers\CityController::class, 'update']);
$app->delete('cityDelete', '/api/v1/city/{uuid}', [\App\Controllers\CityController::class, 'delete']);

//QuestController
$app->get('quest', '/api/v1/quest/{uuid}', [\App\Controllers\QuestController::class, 'quest']);
$app->get('quests', '/api/v1/quests', [\App\Controllers\QuestController::class, 'quests']);
$app->post('questCreate', '/api/v1/quest', [\App\Controllers\QuestController::class, 'create']);
$app->put('questUpdate', '/api/v1/quest/{uuid}', [\App\Controllers\QuestController::class, 'update']);
$app->delete('questDelete', '/api/v1/quest/{uuid}', [\App\Controllers\QuestController::class, 'delete']);

//QuestQuestionController
$app->get('questQuestion', '/api/v1/question/{uuid}', [\App\Controllers\QuestQuestionController::class, 'question']);
$app->get('quests', '/api/v1/questions/{questUuid}', [\App\Controllers\QuestQuestionController::class, 'questions']);
$app->post('questionCreate', '/api/v1/question', [\App\Controllers\QuestQuestionController::class, 'create']);
$app->put('questionUpdate', '/api/v1/question/{uuid}', [\App\Controllers\QuestQuestionController::class, 'update']);
$app->delete('questionDelete', '/api/v1/question/{uuid}', [\App\Controllers\QuestQuestionController::class, 'delete']);