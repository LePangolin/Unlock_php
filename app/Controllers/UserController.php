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
            $json = json_encode(['code' => 400, 'message' => 'Email déjà utilisé']);
            $response->getBody()->write($json);
            return $response->withHeader('Content-Type', 'application/json');
        }
    }

    public function login(Request $request, Response $response): Response
    {
        $user = $this->userService->logIn($request->getParsedBody()['user'], $request->getParsedBody()['pswd']);
        if($user){
            $_SESSION['user'] = $user;
            // TODO : redirect to menu
        }else{
            $json = json_encode(array('code' => 400, 'message' => "Email ou mot de passe incorrect"));
            $response->getBody()->write($json);
            return $response->withHeader('Content-Type', 'application/json');
        }
    }
}

?>