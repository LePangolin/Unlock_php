<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;
use App\Controllers\UserController;

require __DIR__ . '/../vendor/autoload.php';


$container = require __DIR__ . '/../bootstrap.php';
AppFactory::setContainer($container);

$app = AppFactory::create();

$twig = Twig::create(__DIR__ . '/../app/Views/templates', ['cache' => false]);

$app->add(TwigMiddleware::create($app, $twig));

$app->get('/', function (Request $request, Response $response, $args) {
    // utilise controller
    $view = Twig::fromRequest($request);
    return $view->render($response, 'index.html.twig', [
        'title' => 'Accueil',
        'content' => 'Incroyabel ça marche'
    ]);
})->setName('Index');

$app->get('/users', \App\Controllers\UserController::class . ':test');

$app->run();
