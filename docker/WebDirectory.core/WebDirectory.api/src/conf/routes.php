<?php
declare(strict_types=1);


use webdirectory\api\app\actions\GetEntreeByIdAction;
use webdirectory\api\app\actions\GetDepartementsAction;
use webdirectory\api\app\actions\GetEntreesDeDepartementAction;
use webdirectory\api\app\actions\GetEntreesAction;

return function( \Slim\App $app): \Slim\App {

    $app->get('/api/services[/]', GetDepartementsAction::class)->setName('services');

    $app->get('/api/entrees[/]', GetEntreesAction::class)->setName('entrees');

    $app->get('/api/entrees/{id}[/]', GetEntreeByIdAction::class)->setName('entreesId');

    $app->get('/api/services/{id}/entrees[/]', GetEntreesDeDepartementAction::class)->setName('entreesDeService');

    return $app;

};