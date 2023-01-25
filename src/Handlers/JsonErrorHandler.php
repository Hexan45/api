<?php

namespace src\Handlers;

use Slim\Interfaces\ErrorRendererInterface;
use \Throwable;

class JsonErrorHandler implements ErrorRendererInterface
{
    public function __invoke(Throwable $exception, bool $displayErrorDetails) : string
    {
        $payload = [
            'success' => 'false',
            'message' => $exception->getMessage()
        ];

        return (string) json_encode($payload);
    }
}