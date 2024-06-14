<?php

namespace webdirectory\api\app\actions;

use webdirectory\api\core\service\EntreeService;
use webdirectory\api\core\service\IEntreeService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class GetEntreesAction extends AbstractAction{

    private IEntreeService $entree;
    public function __construct(){
        $this->entree = new EntreeService();
    }
    public function __invoke(Request $request, Response $response, array $args): Response{
        $sort = $request->getQueryParams()['sort'] ?? 'nom-asc';
        $prestations = $this->entree->getEntrees($sort);

        $response->getBody()->write(json_encode($prestations));
        return $response->withHeader('Content-Type', 'application/json');

    }
}