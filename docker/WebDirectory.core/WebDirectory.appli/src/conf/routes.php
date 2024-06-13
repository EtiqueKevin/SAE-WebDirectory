<?php
declare(strict_types=1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

return function( \Slim\App $app): \Slim\App {


    $app->get('/', function (Request $request, Response $response, array $args) {
        $view = Twig::fromRequest($request);
        return $view->render($response, 'VueHome.twig');
    });

    return $app;

};