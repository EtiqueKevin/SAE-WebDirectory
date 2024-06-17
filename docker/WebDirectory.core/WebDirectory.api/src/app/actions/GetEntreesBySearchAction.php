<?php

namespace webdirectory\api\app\actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpBadRequestException;
use webdirectory\api\core\service\EntreeService;
use webdirectory\api\core\service\IEntreeService;
use webdirectory\api\core\service\OrmException;

class GetEntreesBySearchAction extends AbstractAction
{

    private IEntreeService $entreeService;

    public function __construct()
    {
        $this->entreeService = new EntreeService();
    }

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $search = $request->getQueryParams()['q'] ?? null;
        $sort = $request->getQueryParams()['sort'] ?? "nom-asc";
        try{
            $entrees = $this->entreeService->getEntreesBySearch($search, $sort);
        }
        catch(OrmException $e){
            throw new HttpBadRequestException($request, $e->getMessage());
        }

        $response->getBody()->write(json_encode($entrees));
        return $response->withHeader('Content-Type', 'application/json');
    }
}