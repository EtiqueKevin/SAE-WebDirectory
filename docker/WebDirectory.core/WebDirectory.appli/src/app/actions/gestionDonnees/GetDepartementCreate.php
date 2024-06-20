<?php

namespace WebDirectory\appli\app\actions\gestionDonnees;

use Slim\Exception\HttpBadRequestException;
use Slim\Views\Twig;
use WebDirectory\appli\app\actions\AbstractAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use WebDirectory\appli\app\utils\CsrfService;
use WebDirectory\appli\core\service\DepartementService;
use WebDirectory\appli\core\service\IDepartementService;
use WebDirectory\appli\core\service\IUtilisateurService;
use WebDirectory\appli\core\service\OrmException;
use WebDirectory\appli\core\service\UtilisateurService;

class GetDepartementCreate extends AbstractAction{

    private IDepartementService $departementService;

    private IUtilisateurService $userService;

    public function __construct(){
        $this->departementService = new DepartementService();
        $this->userService = new UtilisateurService();
    }

    public function __invoke(Request $request, Response $response, array $args): Response{
        if (!isset($_SESSION['user'])) {
            throw new HttpBadRequestException($request, "Vous devez être connecté pour accéder à cette page");
        }

        try {
            $res = $this->userService->checkUserPermission($_SESSION['user']['role'],1);
        } catch (OrmException $e) {
            throw new HttpBadRequestException($request, $e->getMessage());
        }

        if (!$res) {
            throw new HttpBadRequestException($request, "Vous n'avez pas les droits pour accéder à cette page");
        }

        $view = Twig::fromRequest($request);
        return $view->render($response, 'VueGetDepartementCreate.twig', ['csrf'=> CsrfService::generate(), 'connecte'=> isset($_SESSION['user'])]);
    }

}