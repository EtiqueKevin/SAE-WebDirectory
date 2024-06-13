<?php
declare(strict_types=1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
use WebDirectory\appli\app\actions\gestionDonnees\GetEntreeCreate;
use WebDirectory\appli\app\actions\gestionDonnees\PostEntreeCreate;

return function( \Slim\App $app): \Slim\App {


    $app->get('/', function (Request $request, Response $response, array $args) {
        $view = Twig::fromRequest($request);
        return $view->render($response, 'VueHome.twig');
    });

    $app->get('/entree/create[/]', GetEntreeCreate::class)->setName('getEntreeCreate');

    $app->post('/entree/create[/]', PostEntreeCreate::class)->setName('postEntreeCreate');

    return $app;

};