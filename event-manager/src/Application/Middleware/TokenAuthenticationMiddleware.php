<?php


namespace App\Application\Middleware;

use Firebase\JWT\Key;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;
use Firebase\JWT\JWT;

class TokenAuthenticationMiddleware
{
    private $jwtSecret;

    public function __construct(string $jwtSecret)
    {
        $this->jwtSecret = $jwtSecret;
    }

    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $token = $request->getHeaderLine('Authorization');

        if (empty($token)) {
            $response = new Response(401);
            $response = $response->withHeader('Content-Type', 'application/json');
            $response->getBody()->write(json_encode(['error' => 'Token is missing']));
            return $response;
        }

        try {
            $decodedToken = JWT::decode($token, new Key($this->jwtSecret, 'HS256'));
        } catch (\Exception $e) {
            $response = new Response(401);
            $response = $response->withHeader('Content-Type', 'application/json');
            $response->getBody()->write(json_encode(['error' => 'Invalid Token']));
            return $response;
        }

        if (isset($decodedToken->exp) && $decodedToken->exp < time()) {
            $response = new Response(401);
            $response = $response->withHeader('Content-Type', 'application/json');
            $response->getBody()->write(json_encode(['error' => 'Expired Token']));
            return $response;
        }

        return $handler->handle($request);
    }
}
