<?php

    use Slim\Factory\AppFactory;
    use core\Config\Manager\Config;
    use Dotenv\Dotenv;
    use src\Middlewares\BodyParserMiddleware;
    use src\Handlers\JsonErrorHandler;

    //PSR-4 autoloading from composer
    require_once dirname(__DIR__) . '/vendor/autoload.php';

    //Displaying errors turn on
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    //Initialize dotenv configuration
    (Dotenv::createImmutable(dirname(__DIR__)))->safeLoad();

    //New app instance
    $api = AppFactory::create();

    //Loading Property design pattern
    Config::load();

    //Slim middleware settings
    $api->addRoutingMiddleware();

    //Middleware for parsing body in PUT or PATCH methods
    $api->add(new BodyParserMiddleware());

    $errorMiddleware = $api->addErrorMiddleware(Config::$configData['errors']['error_details'], Config::$configData['errors']['log_error'], Config::$configData['errors']['log_details']);
    $errorHandler = $errorMiddleware->getDefaultErrorHandler();
    $errorHandler->registerErrorRenderer('application/json', JsonErrorHandler::class);
    $errorHandler->forceContentType('application/json');