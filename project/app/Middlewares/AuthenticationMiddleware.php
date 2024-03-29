<?php 

namespace App\Middlewares;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\TextResponse;

class AuthenticationMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface {
        
        $auth = $_SERVER['auth'] ?? false;
        if ($auth) {
            $sessionUserId = $_SESSION['userId'] ?? null;
            if (!$sessionUserId) {
                return new TextResponse("Ruta no permitida", 401);
            }
        }
        return $handler->handle($request);
    }
}