<?php

namespace WebDirectory\appli\app\actions\gestionDonnees;

use Slim\Exception\HttpBadRequestException;
use Slim\Views\Twig;
use WebDirectory\appli\app\actions\AbstractAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use WebDirectory\appli\core\service\DepartementService;
use WebDirectory\appli\core\service\EntreeService;
use WebDirectory\appli\core\service\IDepartementService;
use WebDirectory\appli\core\service\IEntreeService;
use WebDirectory\appli\core\service\IUtilisateurService;
use WebDirectory\appli\core\service\OrmException;
use WebDirectory\appli\core\service\UtilisateurService;

class PostEntreeExport extends AbstractAction{

    private IEntreeService $entreeService;
    private IUtilisateurService $userService;


    public function __construct(){
        $this->entreeService = new EntreeService();
        $this->userService = new UtilisateurService();
    }

    public function __invoke(Request $request, Response $response, array $args): Response{

        $body = $request->getParsedBody();

        if (!isset($_SESSION['user'])) {
            throw new HttpBadRequestException($request, "Vous devez être connecté pour accéder à cette page");
        }

        $res = $this->userService->checkUserPermission($_SESSION['user']['role'],1);
        if (!$res) {
            throw new HttpBadRequestException($request, "Vous n'avez pas les droits pour accéder à cette page");
        }

        try {
            if($body['format'] == 'CSV'){
                $this->entreeService->exportCSV();
            }elseif($body['format'] == 'PDF'){
                $this->entreeService->exportPDF();
            }else{
                throw new HttpBadRequestException($request, "Format de fichier non supporté");
            }
        } catch (OrmException $e) {
            throw new HttpBadRequestException($request, $e->getMessage());
        }

        return $response->withHeader('Location', '/entrees')->withStatus(302);
    }

}