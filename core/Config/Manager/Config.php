<?php

namespace core\Config\Manager;

class Config
{
    public static array $configData = array();

    public static function load() : void
    {
        $filePath = dirname(__DIR__) . '/';

        $scannedDirectories = array_diff(scandir(dirname(__DIR__)), array('.', '..'));

        $scannedDirectories = array_filter($scannedDirectories, function($value) use($filePath) {
            $path = $filePath . $value;
            return (is_file($path) && pathinfo($path, PATHINFO_EXTENSION) == 'php');
        });

        foreach($scannedDirectories as $configFile)
        {
            self::$configData = array_merge(self::$configData, include($filePath . $configFile));
        }
    }
}