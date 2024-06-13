<?php

namespace webdirectory\api\app\actions;

use webdirectory\api\core\service\EntreeService;
use webdirectory\api\core\service\IEntreeService;
use webdirectory\api\core\service\OrmException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpNotFoundException;

class GetEntreesDeDepartementAction extends AbstractAction{

    private IEntreeService $entreeService;
    public function __construct(){
        $this->entreeService = new EntreeService();
    }
    public function __invoke(Request $request, Response $response, array $args): Response {
        try {
            $entrees = $this->entreeService->getEntreesByService($args['id']);
        }catch (OrmException $e){
            throw new HttpBadRequestException($request, $e->getMessage());
        }

        if (empty($entrees)){
            throw new HttpNotFoundException($request, "Aucune prestation n'a été trouvée pour cette catégorie");
        }


        $response = $response->withHeader('Content-Type', 'application/json');
        $response->getBody()->write(json_encode($entrees));
        return $response;
    }
}