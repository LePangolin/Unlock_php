<?php

namespace App\Controllers;

use App\Services\CardService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Services\GameService;
use App\Services\CardStateService;
use Slim\Views\Twig;
use App\Helper\Enum;

class GameController
{

    private Twig $twig;
    private GameService $gameService;
    private CardService $cardService;
    private CardStateService $cardStateService;

    private array $drawPile = [];
    private array $discardPile = [];
    private array $gameboard = [];

    public function __construct(Twig $twig, GameService $gameService, CardStateService $cardStateService, CardService $cardService)
    {
        $this->twig = $twig;
        $this->gameService = $gameService;
        $this->cardStateService = $cardStateService;
        $this->cardService = $cardService;
    }


    /* Affichage de la page de jeu */
    public function game(Request $request, Response $response, $args): Response
    {
        /* Récupérations des données de la partie */
        $cards = $this->gameService->getGame($args['id'], $this->cardStateService, $this->cardService);
        $this->drawPile = $cards[0];
        $this->discardPile = $cards[1];
        $this->gameboard = $cards[2];

        // $json = json_encode($this->drawPile);
        // $response->getBody()->write($json);
        // return $response->withHeader('Content-Type', 'application/json');

        /* Appel de la vue */
        return $this->twig->render($response, 'board.html.twig', [
            'title' => 'Gameboard',
            'sessions' => $_SESSION['user'],
            'drawPile' => $this->drawPile,
            'discardPile' => $this->discardPile,
            'gameboard' => $this->gameboard,
        ]);
    }

    public function createGame(Request $request, Response $response, $args): Response
    {
        $gameId = $this->gameService->createGame($_SESSION['user']->getId(), $request->getParsedBody()['decks'], $this->cardStateService, $this->cardService);
        return $response->withHeader('Location', '/game/' . $gameId)->withStatus(302);
    }
}
