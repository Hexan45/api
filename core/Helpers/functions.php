<?php
    declare(strict_types=1);

    if (!function_exists('envData'))
    {
        function envData(string $name, string $alternativeResult = '') : string
        {
            return (isset($_ENV[$name])) ? $_ENV[$name] : $alternativeResult;
        }
    }