<?php

use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

session_start();

$container = require __DIR__ . '/../bootstrap.php';
AppFactory::setContainer($container);

$app = AppFactory::create();

$app->addBodyParsingMiddleware();

// ROUTE GET
$app->get('/', \App\Controllers\HTMLController::class . ':acceuil')->setName('acceuil');


// ROUTE POST
$app->post('/login', \App\Controllers\UserController::class . ':login')->setName('login');
$app->post('/signup', \App\Controllers\UserController::class . ':signUp')->setName('signup');

$app->run();
