<?php

namespace webdirectory\api\app\actions;

use webdirectory\api\core\service\EntreeService;
use webdirectory\api\core\service\IEntreeService;
use webdirectory\api\core\service\OrmException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpBadRequestException;

class GetEntreeByIdAction extends AbstractAction
{
    private IEntreeService $entreeService;

    public function __construct()
    {
        $this->entreeService = new EntreeService();
    }

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        try {
            $entree = $this->entreeService->getEntreeById($args['id']);
        } catch (OrmException $e) {
            throw new HttpBadRequestException($request, $e->getMessage());
        }

        $response->getBody()->write(json_encode($entree));
        return $response->withHeader('Content-Type', 'application/json');
    }
}