<?php
require_once(dirname(__DIR__) . '/Helpers/functions.php');

return match (envData('APPLICATION_STATUS'))
{
    'development' => [
        'errors' => [
            'php_parser' => true,
            'error_details' => true,
            'log_error' => true,
            'log_details' => true
        ]
    ],
    'production' => [
        'errors' => [
            'php_parser' => false,
            'error_details' => false,
            'log_error' => false,
            'log_details' => false
        ]
    ]
};