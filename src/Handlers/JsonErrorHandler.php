<?php

namespace src\Handlers;

use Slim\Interfaces\ErrorRendererInterface;
use \Throwable;

class JsonErrorHandler implements ErrorRendererInterface
{
    public function __invoke(Throwable $exception, bool $displayErrorDetails) : string
    {

        if ($displayErrorDetails)
        {
            $message = $exception->getMessage() . ' With status code ' . $exception->getCode();
        } else {
            $message = 'Error detected with status code ' . $exception->getCode();
        }

        $payload = [
            'success' => 'false',
            'message' => $message
        ];

        return (string) json_encode($payload);
    }
}