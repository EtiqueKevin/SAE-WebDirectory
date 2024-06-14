<?php

namespace WebDirectory\appli\app\actions\authentification;

use Slim\Views\Twig;
use WebDirectory\appli\app\actions\AbstractAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use WebDirectory\appli\app\utils\CsrfService;

class GetAuth extends AbstractAction{

    public function __invoke(Request $request, Response $response, array $args): Response{

        $view =Twig::fromRequest($request);
        return $view->render($response, 'VueGetAuth.twig', ['csrf'=> CsrfService::generate()]);
    }
}