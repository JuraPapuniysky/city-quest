<?php

use DI\Container;

$container = new Container();

$config = require __DIR__.'/config.php';

foreach ($config['dependencies'] as $name => $value) {
    $container->set($name, $value);
}

return $container;
