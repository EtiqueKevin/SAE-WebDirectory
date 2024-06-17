<?php
declare(strict_types=1);


use Slim\Exception\HttpNotFoundException;
use webdirectory\api\app\actions\GetDepartementByIdAction;
use webdirectory\api\app\actions\getEntreesByDepartementAndSearchSortedAction;
use webdirectory\api\app\actions\GetEntreesBySearchAction;
use webdirectory\api\app\actions\GetEntreeByIdAction;
use webdirectory\api\app\actions\GetDepartementsAction;
use webdirectory\api\app\actions\GetEntreesDeDepartementAction;
use webdirectory\api\app\actions\GetEntreesAction;
use webdirectory\api\app\actions\GetEntreesSorted;

return function( \Slim\App $app): \Slim\App {

    $app->get('/api/services[/]', GetDepartementsAction::class)->setName('services');

    $app->get('/api/entrees[/]', GetEntreesAction::class)->setName('entrees');

    $app->get('/api/entrees/search[/]', GetEntreesBySearchAction::class)->setName('entreesBySearch');

    $app->get('/api/entrees/{id}[/]', GetEntreeByIdAction::class)->setName('entreesId');

    $app->get('/api/services/{id}/entrees[/]', GetEntreesDeDepartementAction::class)->setName('entreesDeService');

    $app->get('/api/articles[/]', GetEntreesSorted::class)->setName('entreesSorted');

    $app->get('/api/services/{id}[/]', GetDepartementByIdAction::class)->setName('entreeById');

    $app->get('/api/services/{id}/entrees/search[/]', GetEntreesByDepartementAndSearchSortedAction::class)->setName('entreesByDepartementAndSearchSorted');


    $app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function ($request, $response) {
        throw new HttpNotFoundException($request);
    });

    return $app;

};