<?php 

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Services\UserService;

class UserController
{
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function signUp(Request $request, Response $response): Response
    {
        $user = $this->userService->signUp($request->getParsedBody()['user'], $request->getParsedBody()['pswd']);
        if($user){
            $_SESSION['user'] = $user;
            // TODO : redirect to menu
        }else{
            return $response->withHeader('Location', '/?message=Email déjà utilisé')->withStatus(302);
        }
    }

    public function login(Request $request, Response $response): Response
    {
        $user = $this->userService->logIn($request->getParsedBody()['user'], $request->getParsedBody()['pswd']);
        if($user){
            $_SESSION['user'] = $user;
            return $response->withHeader('Location', '/tmp')->withStatus(302);
        }else{
            return $response->withHeader('Location', '/?message=Email ou mot de passe incorrect')->withStatus(302);
        }
    }
}

?>