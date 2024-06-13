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

class PostEntreesParDepartementAffichage extends AbstractAction{

    private  IEntreeService $entreeService;
    private  IDepartementService $departementService;

    public function __construct(){
        $this->entreeService = new EntreeService();
        $this->departementService = new DepartementService();
    }

    public function __invoke(Request $request, Response $response, array $args): Response{

        $id = $request->getParsedBody();
        return $response->withHeader('Location', '/entreesParDepartement?id='.$id['id'])->withStatus(302);
    }

}