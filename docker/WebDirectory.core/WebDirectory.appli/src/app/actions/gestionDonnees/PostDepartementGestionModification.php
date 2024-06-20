<?php

namespace WebDirectory\appli\app\actions\gestionDonnees;

use Slim\Exception\HttpBadRequestException;
use Slim\Views\Twig;
use Symfony\Component\Translation\Loader\IcuDatFileLoader;
use WebDirectory\appli\app\actions\AbstractAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use WebDirectory\appli\app\utils\CsrfException;
use WebDirectory\appli\app\utils\CsrfService;
use WebDirectory\appli\core\service\DepartementService;
use WebDirectory\appli\core\service\EntreeService;
use WebDirectory\appli\core\service\IDepartementService;
use WebDirectory\appli\core\service\IEntreeService;
use WebDirectory\appli\core\service\OrmException;

class PostDepartementGestionModification extends AbstractAction{

    private IDepartementService $departementService;

    public function __construct(){
        $this->departementService = new DepartementService();
    }

    public function __invoke(Request $request, Response $response, array $args): Response{

        $args = $request->getParsedBody();
        try {
            CsrfService::check($args['csrf']);
        }catch (CsrfException $e) {
            throw new HttpBadRequestException($request,'csrf token error');
        }

        try {
            $this->departementService->updateDepartement($args);
        } catch (OrmException  $e) {
            throw new HttpBadRequestException($request, $e->getMessage());
        }

        $view = Twig::fromRequest($request);
        return $view->render($response, 'VuePostDepartementModification.twig', ['args' => $args, 'connecte'=> isset($_SESSION['user'])]);
    }

}