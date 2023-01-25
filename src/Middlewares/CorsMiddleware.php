<?php

namespace src\Middlewares;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Routing\RouteContext;

class CorsMiddleware
{
    public function __invoke(Request $request, RequestHandlerInterface $handler) : Response
    {
        $routeContext = RouteContext::fromRequest($request);
        $allowedMethods = $routeContext->getRoutingResults()->getAllowedMethods();
        $requestHeaders = $request->getHeaderLine('Access-Control-Request-Headers');

        $response = $handler->handle($request);

        $response = $response->withHeader('Content-Type', 'application/json')
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Credentials', 'true')
            ->withHeader('Access-Control-Allow-Methods', implode(', ', $allowedMethods))
            ->withHeader('Access-Control-Allow-Headers', $requestHeaders);

        return $response->withStatus(401);
    }
}