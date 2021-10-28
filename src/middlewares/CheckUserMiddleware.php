<?php

namespace App\middlewares;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

class CheckUserMiddleware
{
    public function __invoke(Request $request, RequestHandler $handler ): Response
    {
        $response = $handler->handle($request);

        if (empty($_SESSION['id'])){
            return $response->withHeader('Location', '/');
        }

        return $response;
    }
}