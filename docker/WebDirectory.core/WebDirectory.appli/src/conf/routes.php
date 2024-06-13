<?php
declare(strict_types=1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
use WebDirectory\appli\app\actions\affichageDonnees\GetEntreesAffichage;
use WebDirectory\appli\app\actions\affichageDonnees\GetEntreesParDepartementAffichage;
use WebDirectory\appli\app\actions\affichageDonnees\PostEntreesParDepartementAffichage;
use WebDirectory\appli\app\actions\gestionDonnees\GetDepartementCreate;
use WebDirectory\appli\app\actions\gestionDonnees\GetEntreeCreate;
use WebDirectory\appli\app\actions\gestionDonnees\PostDepartementCreate;
use WebDirectory\appli\app\actions\gestionDonnees\PostEntreeCreate;

return function( \Slim\App $app): \Slim\App {


    $app->get('/', function (Request $request, Response $response, array $args) {
        $view = Twig::fromRequest($request);
        return $view->render($response, 'VueHome.twig');
    });

    $app->get('/entree/create[/]', GetEntreeCreate::class)->setName('getEntreeCreate');

    $app->post('/entree/create[/]', PostEntreeCreate::class)->setName('postEntreeCreate');

    $app->get('/departement/create[/]', GetDepartementCreate::class)->setName('getDepartementCreate');

    $app->post('/departement/create[/]', PostDepartementCreate::class)->setName('postDepartementCreate');

    $app->get('/entrees[/]', GetEntreesAffichage::class)->setName('getEntreesAffichage');

    $app->get('/entreesParDepartement[/]', GetEntreesParDepartementAffichage::class)->setName('getEntreesParDepartementAffichage');

    $app->post('/entreesParDepartement[/]', PostEntreesParDepartementAffichage::class)->setName('postEntreesParDepartementAffichage');

    return $app;

};