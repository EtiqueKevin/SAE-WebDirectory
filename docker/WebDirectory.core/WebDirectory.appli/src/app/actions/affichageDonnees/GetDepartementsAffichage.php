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

class GetDepartementsAffichage extends AbstractAction{

    private  IDepartementService $entreeService;

    public function __construct(){
        $this->entreeService = new DepartementService();
    }

    public function __invoke(Request $request, Response $response, array $args): Response{

        try {
            $departements = $this->entreeService->getDepartement();
        } catch (OrmException $e) {
            throw new HttpBadRequestException($request, $e->getMessage());
        }

        $view = Twig::fromRequest($request);
        return $view->render($response, 'VueGetDepartementsAffichage.twig', ['departements' => $departements['departements'], 'connecte'=> isset($_SESSION['user'])]);
    }

}