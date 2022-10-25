<?php

use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

session_start();

$container = require __DIR__ . '/../bootstrap.php';
AppFactory::setContainer($container);

$app = AppFactory::create();

$app->get('/', \App\Controllers\HTMLController::class . ':acceuil')->setName('acceuil');

$app->get('/users', \App\Controllers\UserController::class . ':test');

$app->get('/gameboard/{gameId}[/]', \App\Controllers\HTMLController::class . ':gameboard')->setName('gameboard');

$app->run();
