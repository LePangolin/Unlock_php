<?php

namespace App\Controllers;

use App\Services\CardService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Services\GameService;
use App\Services\CardStateService;
use Slim\Views\Twig;
use App\Helper\Enum;
use App\Models\Card;

class GameController
{

    private Twig $twig;
    private GameService $gameService;
    private CardService $cardService;
    private CardStateService $cardStateService;

    /* Tableaux correspondants aux différentes positions des cartes (pioche, défausse, jeu) */
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
        /* Récupérations des données de la partie, voir GameService::getGame */
        $cards = $this->gameService->getGame($args['id'], $this->cardStateService, $this->cardService);
        $this->drawPile = $cards[0];
        $this->discardPile = $cards[1];
        $this->gameboard = $cards[2];

        /* On s'assure que la carte Main est bien en position 0 dans le jeu*/
        foreach ($this->gameboard as $key => $card) {
            if ($card['id'] == Card::MAINCARD) {
                $main = $this->gameboard[$key];
                unset($this->gameboard[$key]);
                array_unshift($this->gameboard, $main);
            }
        }

        /* On s'assure que la carte Discard est bien en position 0 dans la défausse*/
        foreach ($this->discardPile as $key => $card) {
            if ($card['id'] == Card::DISCARD_DEFAULT) {
                $discard = $this->discardPile[$key];
                unset($this->discardPile[$key]);
                array_unshift($this->discardPile, $discard);
            }
        }

        /* Appel de la vue en lui passant les tableaux de positions*/
        return $this->twig->render($response, 'board.html.twig', [
            'title' => 'Gameboard',
            'sessions' => $_SESSION['user'],
            'drawPile' => $this->drawPile,
            'discardPile' => $this->discardPile,
            'gameboard' => $this->gameboard,
            'gameId' => $args['id'],
        ]);
    }

    public function createGame(Request $request, Response $response, $args): Response
    {
        $gameId = $this->gameService->createGame($_SESSION['user']->getId(), $request->getParsedBody()['decks'], $this->cardStateService, $this->cardService);
        return $response->withHeader('Location', '/game/' . $gameId)->withStatus(302);
    }

    public function loadSave(Request $request, Response $response, $args): Response
    {
        if (array_key_exists('saves', $request->getParsedBody())) {
            return $response->withHeader('Location', '/game/' . $request->getParsedBody()['saves'])->withStatus(302);
        } 
        return $response->withHeader('Location', '/menu')->withStatus(302);
    }

    public function save(Request $request, Response $response, $args): Response
    { 
        $save = $this->gameService->save($this->cardStateService, $this->cardService);
        if ($save) {
            return $response->withHeader('Location', '/menu')->withStatus(302);
        }
    }

    public function endGame(Request $request, Response $response, $args): Response
    {
        $this->gameService->endGame();
        return $response->withHeader('Location', '/menu')->withStatus(302);
    }
}
