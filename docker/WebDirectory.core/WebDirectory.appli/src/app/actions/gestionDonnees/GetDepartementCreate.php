<?php

namespace WebDirectory\appli\app\actions\gestionDonnees;

use Slim\Exception\HttpBadRequestException;
use Slim\Views\Twig;
use WebDirectory\appli\app\actions\AbstractAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use WebDirectory\appli\core\service\DepartementService;
use WebDirectory\appli\core\service\IDepartementService;
use WebDirectory\appli\core\service\OrmException;

class GetDepartementCreate extends AbstractAction{

    public function __invoke(Request $request, Response $response, array $args): Response{

        $view = Twig::fromRequest($request);
        return $view->render($response, 'VueGetDepartementCreate.twig');
    }

}