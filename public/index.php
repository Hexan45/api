<?php
    declare(strict_types=1);

    use Slim\Routing\RouteCollectorProxy;

    require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'bootstrap.php';

    /*
     * All routes for Application Programming Interface
     */
    $api->group('/api', function(RouteCollectorProxy $api) {

        $api->group('/v1', function(RouteCollectorProxy $api) {

            $api->get('/persons', [src\Controllers\PersonsController::class, 'getAll']);
            $api->get('/persons/{personID:[0-9]+}', [src\Controllers\PersonsController::class, 'getSingle']);
            $api->post('/persons', [src\Controllers\PersonsController::class, 'storageData']);
            $api->put('/persons/{personID:[0-9]+}', [src\Controllers\PersonsController::class, 'updateSingle']);
            $api->delete('/persons/{personID:[0-9]+}', [src\Controllers\PersonsController::class, 'deleteSingle']);

        });

    })->add(new src\Middlewares\CorsMiddleware());

    $api->run();