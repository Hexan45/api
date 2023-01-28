<?php
declare(strict_types=1);

use Slim\Routing\RouteCollectorProxy;

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'bootstrap.php';

/*
* All routes for Application Programming Interface
*/

$api->group('/api', function(RouteCollectorProxy $api) {
    require_once(dirname(__DIR__) . '/src/Routes/v1/personRoutes.php');
})->add(new src\Middlewares\CorsMiddleware());

$api->run();