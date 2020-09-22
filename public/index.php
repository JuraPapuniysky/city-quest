<?php

use PsrFramework\Http\Application;
use Narrowspark\HttpEmitter\SapiEmitter;
use Dotenv\Dotenv;

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$container = require __DIR__ . '/../config/container.php';

$app = new Application($container);

$request = \Laminas\Diactoros\ServerRequestFactory::fromGlobals();

require __DIR__ . '/../config/middlewares.php';
require __DIR__ . '/../config/routes.php';

$response = $app->handle($request);

$emitter = new SapiEmitter();
$emitter->emit($response);


