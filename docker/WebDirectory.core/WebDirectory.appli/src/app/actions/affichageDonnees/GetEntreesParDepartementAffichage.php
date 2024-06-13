<?php

namespace WebDirectory\appli\app\actions\affichageDonnees;

use Slim\Exception\HttpBadRequestException;
use Slim\Views\Twig;
use WebDirectory\appli\app\actions\AbstractAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use WebDirectory\appli\core\service\DepartementService;
use WebDirectory\appli\core\service\EntreeService;
use WebDirectory\appli\core\service\IDepartementService;
use WebDirectory\appli\core\service\IEntreeService;
use WebDirectory\appli\core\service\OrmException;

class GetEntreesParDepartementAffichage extends AbstractAction{

    private  IEntreeService $entreeService;
    private  IDepartementService $departementService;

    public function __construct(){
        $this->entreeService = new EntreeService();
        $this->departementService = new DepartementService();
    }

    public function __invoke(Request $request, Response $response, array $args): Response{

        $id = $request->getQueryParams();

        try {
            if(isset($id['id'])) {
                $departements = $this->departementService->getDepartement();
                $entrees = $this->entreeService->getEntreesByService($id['id']);
            } else {
                $departements = $this->departementService->getDepartement();
                $entrees = $this->entreeService->getEntrees();
            }
        } catch (OrmException $e) {
            throw new HttpBadRequestException($request, $e->getMessage());
        }

        var_dump($id['id'] ?? null);

        $view = Twig::fromRequest($request);
        return $view->render($response, 'VueGetEntreesParDepartementAffichage.twig', ['entrees' => $entrees['entrees'], 'departements' => $departements['departements'], 'selected' => $id['id'] ?? null]);
    }

}