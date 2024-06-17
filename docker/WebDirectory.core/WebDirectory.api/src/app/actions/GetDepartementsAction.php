<?php


namespace webdirectory\api\app\actions;

use webdirectory\api\core\service\IDepartementService;
use webdirectory\api\core\service\DepartementService;
use webdirectory\api\core\service\OrmException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpBadRequestException;

class GetDepartementsAction extends AbstractAction{
    private IDepartementService $departement;
    public function __construct(){
        $this->departement = new DepartementService();
    }

    public function __invoke(Request $request, Response $response, array $args): Response{
        $sort = $request->getQueryParams()['sort'] ?? "nom-asc";

        try {
            $categories = $this->departement->getDepartement($sort);
        }catch (OrmException $e){
            throw new HttpBadRequestException($request, $e->getMessage());
        }

        $response->getBody()->write(json_encode($categories));
        return $response->withHeader('Content-Type', 'application/json');
    }
}