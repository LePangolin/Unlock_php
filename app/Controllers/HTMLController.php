<?php 

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Services\HTMLService;
use Slim\Views\Twig;


class HTMLController
{

    private Twig $twig;

    public function __construct(Twig $twig)
    {
        $this->twig = $twig;
    }

    public function acceuil(Request $request, Response $response): Response
    {
        if( isset($_SESSION['user']) ) {
            return $this->twig->render($response, 'index.html.twig', [
                'title' => 'Acceuil',
                'session' => [
                    'name' => $_SESSION['user']
                ]
            ]);
        } else {
            return $this->twig->render($response, 'index.html.twig', [
                'title' => 'Acceuil',
            ]);
        }
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
}

?>