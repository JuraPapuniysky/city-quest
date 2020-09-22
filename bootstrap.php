<?php
use Dotenv\Dotenv;

require_once "vendor/autoload.php";

$dotenv = Dotenv::createImmutable(__DIR__ . '/');
$dotenv->load();

/** @var \Psr\Container\ContainerInterface $container */
$container = require __DIR__.'/config/container.php';

// Create a simple "default" Doctrine ORM configuration for Annotations
$entityManager = $container->get(\Doctrine\ORM\EntityManagerInterface::class);

