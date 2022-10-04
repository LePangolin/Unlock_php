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

    public function test(Request $request, Response $response): Response
    {
        $user = $this->userService->signUp('test');
        $payload = json_encode($user);
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }
}

?>