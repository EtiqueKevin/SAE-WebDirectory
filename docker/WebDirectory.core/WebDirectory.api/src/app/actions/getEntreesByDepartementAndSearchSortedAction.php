<?php

namespace webdirectory\api\app\actions;


use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use webdirectory\api\core\service\EntreeService;
use webdirectory\api\core\service\IEntreeService;
use webdirectory\api\core\service\OrmException;

class getEntreesByDepartementAndSearchSortedAction extends AbstractAction
{
    private IEntreeService $entree;
    public function __construct(){
        $this->entree = new EntreeService();
    }

    /**
     * @throws OrmException
     */
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $id = $args['id'];
        // récupérer search and sort dans la query
        $search = $request->getQueryParams()['q'] ?? '';
        $sort = $request->getQueryParams()['sort'] ?? 'nom-asc';
        try {
            $prestations = $this->entree->getEntreesByDepartementAndSearchSorted($id, $search, $sort);
        }
        catch (OrmException $e){
            throw new OrmException("Entree non trouvée");
        }

        $response->getBody()->write(json_encode($prestations));
        return $response->withHeader('Content-Type', 'application/json');
    }
}