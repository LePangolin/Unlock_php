<?php 

namespace App\Controllers;

use App\Services\CardService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Services\GameService;
use App\Services\CardStateService;
use Slim\Views\Twig;

class GameController
{

    private Twig $twig;

    public function __construct(Twig $twig, GameService $gameService, CardStateService $cardStateService, CardService $cardService)
    {
        $this->twig = $twig;
        $this->gameService = $gameService;
        $this->cardStateService = $cardStateService;
        $this->cardService = $cardService;
    }


    public function game(Request $request, Response $response, $args): Response
    {
        $cards = $this->gameService->getGame($args['id'], $this->cardStateService, $this->cardService);
        $json = json_encode($cards);
        $response->getBody()->write($json);
        return $response->withHeader('Content-Type', 'application/json');
    }

}
?>