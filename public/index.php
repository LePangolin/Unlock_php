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
$app->get('/game/{id}', \App\Controllers\GameController::class . ':game')->setName('game');
$app->get('/menu', \App\Controllers\HTMLController::class . ':menu')->setName('menu');

// ROUTE POST
$app->post('/login', \App\Controllers\UserController::class . ':login')->setName('login');
$app->post('/signup', \App\Controllers\UserController::class . ':signUp')->setName('signup');
$app->post('/game', \App\Controllers\GameController::class . ':createGame')->setName('createGame');
$app->post('/menu', \App\Controllers\HTMLController::class . ':menu')->setName('menu'); 
$app->post('/save', \App\Controllers\GameController::class . ':save')->setName('save');
$app->post('/loadSave', \App\Controllers\GameController::class . ':loadSave')->setName('loadSave');
$app->post('/endGame', \App\Controllers\GameController::class . ':endGame')->setName('endGame');

$app->get('/gameboard/{gameId}[/]', \App\Controllers\HTMLController::class . ':gameboard')->setName('gameboard');

$app->run();
