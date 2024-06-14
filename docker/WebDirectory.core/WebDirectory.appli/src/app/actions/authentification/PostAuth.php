<?php

namespace WebDirectory\appli\app\actions\authentification;

use Slim\Exception\HttpBadRequestException;
use WebDirectory\appli\app\actions\AbstractAction;
use WebDirectory\appli\app\utils\CsrfException;
use WebDirectory\appli\app\utils\CsrfService;
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
            CsrfService::check($body['csrf']);
        }catch (CsrfException $e) {

            throw new HttpBadRequestException($request,'erreur de jeton csrf');
        }

        try {
            $a = $this->userService->checkUser($body);
        }catch (OrmException $e){
            throw new HttpBadRequestException($request, $e->getMessage());
        }

        if(!$a['reussite']){
            throw new HttpBadRequestException($request, "email ou mot de passe incorrect");
        }else{
            $_SESSION['user']=$a;
        }

        return $response->withHeader('Location', '/')->withStatus(302);
    }
}