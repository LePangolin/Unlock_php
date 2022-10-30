<?php 

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Services\HTMLService;
use App\Services\GameService;
use App\Services\CardService;
use Slim\Views\Twig;


class HTMLController
{

    private Twig $twig;
    private GameService $gameService;
    private CardService $cardService;

    public function __construct(Twig $twig, GameService $gameService, CardService $cardService)
    {
        $this->twig = $twig;
        $this->gameService = $gameService;
        $this->cardService = $cardService;
    }

    public function acceuil(Request $request, Response $response): Response
    {
        $fromError = $request->getQueryParams()['message'] ?? null;
        if($fromError){
            $message = $request->getQueryParams()['message'];
            return $this->twig->render($response, 'index.html.twig',
                [
                    'title' => 'Acceuil',
                    'fromError' => $fromError,
                    "message" => $message
                ]
            );
        }
        return $this->twig->render($response, 'index.html.twig',
            [
                'title' => 'Acceuil',
            ]
        );
    }

    public function gameboard(Request $request, Response $response, $args): Response
    {
       if( isset($_SESSION['user']) ) {
            return $this->twig->render($response, 'board.html.twig', [
                'title' => 'Gameboard',
            ]);
        } else {
            return $this->twig->render($response, 'index.html.twig', [
                'title' => 'Acceuil',
            ]);
        }
    }

    public function menu(Request $request, Response $response, $args): Response
    {
        $deckIds = $this->cardService->getDeckIds();
        $gameIds = $this->gameService->getGameIds();
        if( isset($_SESSION['user']) ) {
            return $this->twig->render($response, 'menu.html.twig', [
                'title' => 'Menu',
                'sessions' => $_SESSION['user'],
                'session_name' => $_SESSION['user']->getEmail(),
                'deckIds' => $deckIds,
                'gameIds' => $gameIds,
            ]);
        } else {
            return $this->twig->render($response, 'index.html.twig', [
                'title' => 'Acceuil',
            ]);
        }
    }
}

?>