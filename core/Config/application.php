<?php
    require_once(dirname(__DIR__) . '/Helpers/functions.php');

    return [
        'errors' => [
            'error_details' => envData('DISPLAY_ERROR_DETAILS', false),
            'log_error' => envData('LOG_ERRORS', false),
            'log_details' => envData('LOG_ERROR_DETAILS', false)
        ]
    ];