<?php 

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Services\GameService;
use App\Services\CardStateService;
use Slim\Views\Twig;

class GameController
{

    private Twig $twig;

    public function __construct(Twig $twig, GameService $gameService, CardStateService $cardStateService)
    {
        $this->twig = $twig;
        $this->gameService = $gameService;
        $this->cardStateService = $cardStateService;
    }


    public function game(Request $request, Response $response, $args): Response
    {
        $cards = $this->gameService->getGame($args['id'], $this->cardStateService);
        // create an array of cards
        $cardsArray = [];
        foreach ($cards as $card) {
            $cardsArray[] = [
                'idGame' => $card->getIdGame(),
                'idCard' => $card->getIdCard(),
                'state' => $card->getIdState(),
                'idDeck' => $card->getIdDeck(),
            ];
        }
        $json = json_encode($cardsArray);
        $response->getBody()->write($json);
        return $response->withHeader('Content-Type', 'application/json');
    }

}
?>