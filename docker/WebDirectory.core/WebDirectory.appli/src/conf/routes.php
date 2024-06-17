<?php
declare(strict_types=1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
use WebDirectory\appli\app\actions\affichageDonnees\GetEntreesAffichage;
use WebDirectory\appli\app\actions\affichageDonnees\GetEntreesParDepartementAffichage;
use WebDirectory\appli\app\actions\affichageDonnees\PostEntreesParDepartementAffichage;
use WebDirectory\appli\app\actions\authentification\GetAuth;
use WebDirectory\appli\app\actions\authentification\GetRegister;
use WebDirectory\appli\app\actions\authentification\PostAuth;
use WebDirectory\appli\app\actions\authentification\PostRegister;
use WebDirectory\appli\app\actions\gestionDonnees\GetDepartementCreate;
use WebDirectory\appli\app\actions\gestionDonnees\GetEntreeCreate;
use WebDirectory\appli\app\actions\gestionDonnees\GetEntreeGestionModification;
use WebDirectory\appli\app\actions\gestionDonnees\PostDepartementCreate;
use WebDirectory\appli\app\actions\gestionDonnees\PostEntreeCreate;
use WebDirectory\appli\app\actions\gestionDonnees\PostEntreeGestionModification;
use WebDirectory\appli\app\actions\gestionDonnees\PostEntreeGestionModificationRedirection;
use WebDirectory\appli\app\actions\gestionDonnees\PostEntreeGestionPublication;
use WebDirectory\appli\app\actions\gestionDonnees\PostEntreeGestionSuppression;

return function( \Slim\App $app): \Slim\App {


    $app->get('/', function (Request $request, Response $response, array $args) {

        $texte = "Bienvenue sur l'application de gestion des entrées";

        if(isset($_SESSION['user'])){
            $user = $_SESSION['user'];
            $texte = "Bienvenue ".$user['email']." sur l'application de gestion des entrées";
        }

        $view = Twig::fromRequest($request);
        return $view->render($response, 'VueHome.twig', ['texte' => $texte]);
    });

    $app->get('/entree/create[/]', GetEntreeCreate::class)->setName('getEntreeCreate');

    $app->post('/entree/create[/]', PostEntreeCreate::class)->setName('postEntreeCreate');

    $app->get('/departement/create[/]', GetDepartementCreate::class)->setName('getDepartementCreate');

    $app->post('/departement/create[/]', PostDepartementCreate::class)->setName('postDepartementCreate');

    $app->get('/entrees[/]', GetEntreesAffichage::class)->setName('getEntreesAffichage');

    $app->get('/entreesParDepartement[/]', GetEntreesParDepartementAffichage::class)->setName('getEntreesParDepartementAffichage');

    $app->post('/entreesParDepartement[/]', PostEntreesParDepartementAffichage::class)->setName('postEntreesParDepartementAffichage');

    $app->get('/register[/]', GetRegister::class)->setName('getRegister');

    $app->post('/register[/]', PostRegister::class)->setName('postRegister');

    $app->get('/auth[/]', GetAuth::class)->setName('getAuth');

    $app->post('/auth[/]', PostAuth::class)->setName('postAuth');

    $app->get('/logout[/]', function (Request $request, Response $response, array $args) {
        unset($_SESSION['user']);
        return $response->withHeader('Location', '/')->withStatus(302);
    })->setName('logout');

    $app->post('/entrees/gestionPublication[/]',PostEntreeGestionPublication::class )->setName('gestionPublication');

    $app->get('/entree/modification[/]', GetEntreeGestionModification::class )->setName('getEntreeGestionModification');

    $app->post('/entree/modification[/]', PostEntreeGestionModification::class )->setName('postEntreeGestionModification');

    $app->post('/entree/suppression[/]', PostEntreeGestionSuppression::class )->setName('gestionSuppression');

    $app->post('/entreeModificationRedirection', PostEntreeGestionModificationRedirection::class)->setName('postEntreeModificationRedirection');



    return $app;

};