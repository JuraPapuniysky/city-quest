<?php
/** @var \PsrFramework\Http\Application $app */

//Country controller
$app->get('country', '/api/v1/country/{uuid}', [\Geo\Controllers\CountryController::class, 'country'], true);
$app->get('countries', '/api/v1/countries', [\Geo\Controllers\CountryController::class, 'countries'], true);
$app->get('countriesSearch', '/api/v1/countries/search/{prefix}', [\Geo\Controllers\CountryController::class, 'search']);
$app->post('countryCreate', '/api/v1/country', [\Geo\Controllers\CountryController::class, 'create'], true);
$app->put('countryUpdate', '/api/v1/country/{uuid}', [\Geo\Controllers\CountryController::class, 'update'], true);
$app->delete('countryDelete', '/api/v1/country/{uuid}', [\Geo\Controllers\CountryController::class, 'delete'], true);

//CityController
$app->get('city', '/api/v1/city/{uuid}', [\Geo\Controllers\CityController::class, 'city'], true);
$app->get('cities', '/api/v1/cities/{countryUuid}', [\Geo\Controllers\CityController::class, 'cities'], true);
$app->get('citiesSearch', '/api/v1/cities/search/{countryUuid}/{prefix}', [\Geo\Controllers\CityController::class, 'search']);
$app->post('cityCreate', '/api/v1/city', [\Geo\Controllers\CityController::class, 'create'], true);
$app->put('cityUpdate', '/api/v1/city/{uuid}', [\Geo\Controllers\CityController::class, 'update'], true);
$app->delete('cityDelete', '/api/v1/city/{uuid}', [\Geo\Controllers\CityController::class, 'delete'], true);
