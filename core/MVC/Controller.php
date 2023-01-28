<?php

namespace core\MVC;

use core\MVC\Model;
use Psr\Http\Message\ResponseInterface as Response;

abstract class Controller
{

    const MODELS_PATH = 'src\\Models\\';

    protected function makeModel(string $modelName, ?int $id = null): Model|false
    {
        $namespace = self::MODELS_PATH . $modelName . 'Model';
        if(class_exists($namespace))
        {
            return new $namespace($id);
        }

        return false;
    }
}