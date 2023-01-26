<?php
declare(strict_types=1);

use Slim\Routing\RouteCollectorProxy;

$api->group('/v1', function(RouteCollectorProxy $api) {

    $api->get('/persons', [\src\Controllers\v1\PersonsController::class, 'getAll']);
    $api->get('/persons/{personID:[0-9]+}', [\src\Controllers\v1\PersonsController::class, 'getSingle']);
    $api->post('/persons', [\src\Controllers\v1\PersonsController::class, 'storageData']);
    $api->put('/persons/{personID:[0-9]+}', [\src\Controllers\v1\PersonsController::class, 'updateSingle']);
    $api->delete('/persons/{personID:[0-9]+}', [\src\Controllers\v1\PersonsController::class, 'deleteSingle']);

});