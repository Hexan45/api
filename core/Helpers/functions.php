<?php
    declare(strict_types=1);

    if (!function_exists('envData'))
    {
        function envData(string $name, string $alternativeResult = '') : string
        {
            return (isset($_ENV[$name])) ? $_ENV[$name] : $alternativeResult;
        }
    }

    if (!function_exists('loadFiles'))
    {
        function loadFiles(string $filesPath, string $extension) : void
        {
            $files = glob($filesPath . '*.' . $extension);
            foreach($files as $filePath)
            {
                require_once($filePath);
            }
        }
    }