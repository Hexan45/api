<?php

namespace src\Middlewares;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class BodyParserMiddleware
{
    public function __invoke(Request $request, RequestHandler $handler) : Response
    {
        $method = $request->getMethod();

        if ($method == 'PATCH' || $method == 'PUT')
        {
            parse_str($request->getBody()->__toString(), $parsedData);
            $request = $request->withParsedBody($parsedData);
        }

        return $handler->handle($request);
    }
}