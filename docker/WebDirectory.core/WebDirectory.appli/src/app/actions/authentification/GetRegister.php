<?php

namespace WebDirectory\appli\app\actions\authentification;

use Slim\Exception\HttpBadRequestException;
use Slim\Views\Twig;
use WebDirectory\appli\app\actions\AbstractAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use WebDirectory\appli\core\service\IUtilisateurService;
use WebDirectory\appli\core\service\UtilisateurService;


class GetRegister extends AbstractAction{

    private IUtilisateurService $userService;

    public function __construct(){
        $this->userService = new UtilisateurService();
    }

    public function __invoke(Request $request, Response $response, array $args): Response{

        if(!isset($_SESSION['user'])){
            return $response->withHeader('Location', '/')->withStatus(302);
        }

        $res = $this->userService->checkUserPermission($_SESSION['user']['role'],100);

        if (!$res) {
            throw new HttpBadRequestException($request, "Vous n'avez pas les droits pour accéder à cette page");
        }

        $view =Twig::fromRequest($request);
        return $view->render($response, 'VueGetRegister.twig');
    }
}