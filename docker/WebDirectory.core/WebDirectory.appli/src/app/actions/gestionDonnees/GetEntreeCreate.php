<?php

namespace WebDirectory\appli\app\actions\gestionDonnees;

use Slim\Views\Twig;
use WebDirectory\appli\app\actions\AbstractAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class GetEntreeCreate extends AbstractAction{

    public function __invoke(Request $request, Response $response, array $args): Response{

        $view = Twig::fromRequest($request);
        return $view->render($response, 'VueGetEntreeCreate.twig');
    }

}