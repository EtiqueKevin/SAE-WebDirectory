<?php

namespace WebDirectory\appli\app\actions\gestionDonnees;

use Slim\Exception\HttpBadRequestException;
use Slim\Views\Twig;
use WebDirectory\appli\app\actions\AbstractAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use WebDirectory\appli\app\utils\CsrfService;
use WebDirectory\appli\core\service\DepartementService;
use WebDirectory\appli\core\service\EntreeService;
use WebDirectory\appli\core\service\IDepartementService;
use WebDirectory\appli\core\service\IEntreeService;
use WebDirectory\appli\core\service\IUtilisateurService;
use WebDirectory\appli\core\service\OrmException;
use WebDirectory\appli\core\service\UtilisateurService;

class GetEntreeGestionModification extends AbstractAction{

    private IUtilisateurService $userService;

    private IEntreeService $entreeService;

    private IDepartementService $departementService;

    public function __construct(){

        $this->entreeService = new EntreeService();

        $this->userService = new UtilisateurService();

        $this->departementService = new DepartementService();
    }

    public function __invoke(Request $request, Response $response, array $args): Response{

        if (!isset($_SESSION['user'])) {
            throw new HttpBadRequestException($request, "Vous devez être connecté pour accéder à cette page");
        }

        $id = $request->getQueryParams();

        $res = $this->userService->checkUserPermission($_SESSION['user']['role'],1);
        if (!$res) {
            throw new HttpBadRequestException($request, "Vous n'avez pas les droits pour accéder à cette page");
        }

        try {
            $entree = $this->entreeService->getEntreeById($id['id']);
            $departements = $this->departementService->getDepartement();
        } catch (OrmException $e) {
            throw new HttpBadRequestException($request, $e->getMessage());
        }

        $token = CsrfService::generate();

        $listeDepartement = array();
        foreach($entree['entree']['departements'] as $d){
            $listeDepartement[] = $d['id'];
        }

        $view = Twig::fromRequest($request);
        return $view->render($response, 'VueGetEntreeModification.twig', ['departements' => $departements['departements'],'entree'=> $entree['entree'], 'listeDepartement'=> $listeDepartement,'id'=> $id['id'],'csrf'=> $token]);
    }

}