<?php
    require_once(dirname(__DIR__) . '/Helpers/functions.php');

    return [
        'default_connector' => envData('DATABASE_MODULE', 'PDO'),

        'PDO' => [
            'database_engine' => envData('DATABASE_ENGINE', 'mysql'),
            'database_port' => envData('DATABASE_PORT', '3306'),
            'database_charset' => envData('DATABASE_CHARSET', 'utf8mb4'),
            'database_name' => envData('DATABASE_NAME', 'database'),
            'database_host' => envData('DATABASE_HOST', 'localhost'),
            'database_user' => envData('DATABASE_USER', 'root'),
            'database_password' => envData('DATABASE_PASSWORD', '')
        ],

        'Mongodb' => [
            'database_engine' => envData('DATABASE_ENGINE', 'mongodb'),
            'database_user' => envData('DATABASE_USER', '<your username>'),
            'database_password' => envData('DATABASE_PASSWORD', '<your password>'),
            'database_cluster' => envData('DATABASE_CLUSTER', '<your cluster>')
        ]
    ];