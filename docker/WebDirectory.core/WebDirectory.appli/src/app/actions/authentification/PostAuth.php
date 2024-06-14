<?php

namespace WebDirectory\appli\app\actions\authentification;

use Slim\Exception\HttpBadRequestException;
use WebDirectory\appli\app\actions\AbstractAction;
use WebDirectory\appli\core\service\IUtilisateurService;
use WebDirectory\appli\core\service\OrmException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use WebDirectory\appli\core\service\UtilisateurService;

class PostAuth extends AbstractAction{

    private IUtilisateurService $userService;
    public function __construct(){
        $this->userService = new UtilisateurService();
    }
    public function __invoke(Request $request, Response $response, array $args): Response{

        $body = $request->getParsedBody();

        if (!isset($body['email']) || !isset($body['password'])) {
            throw new HttpBadRequestException($request, "email ou mot de passe absent");
        }

        try {
            $a = $this->userService->checkUser($body);
        }catch (OrmException $e){
            throw new HttpBadRequestException($request, $e->getMessage());
        }

        if(!$a){
            throw new HttpBadRequestException($request, "email ou mot de passe incorrect");
        }

        return $response->withHeader('Location', '/')->withStatus(302);
    }
}