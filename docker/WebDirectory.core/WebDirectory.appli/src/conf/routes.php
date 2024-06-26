<?php
declare(strict_types=1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
use WebDirectory\appli\app\actions\affichageDonnees\GetDepartementsAffichage;
use WebDirectory\appli\app\actions\affichageDonnees\GetEntreesAffichage;
use WebDirectory\appli\app\actions\affichageDonnees\GetEntreesParDepartementAffichage;
use WebDirectory\appli\app\actions\affichageDonnees\PostEntreesParDepartementAffichage;
use WebDirectory\appli\app\actions\authentification\GetAuth;
use WebDirectory\appli\app\actions\authentification\GetRegister;
use WebDirectory\appli\app\actions\authentification\PostAuth;
use WebDirectory\appli\app\actions\authentification\PostRegister;
use WebDirectory\appli\app\actions\gestionDonnees\GetDepartementCreate;
use WebDirectory\appli\app\actions\gestionDonnees\GetDepartementGestionModification;
use WebDirectory\appli\app\actions\gestionDonnees\GetEntreeCreate;
use WebDirectory\appli\app\actions\gestionDonnees\GetEntreeGestionModification;
use WebDirectory\appli\app\actions\gestionDonnees\PostDepartementCreate;
use WebDirectory\appli\app\actions\gestionDonnees\PostDepartementGestionModification;
use WebDirectory\appli\app\actions\gestionDonnees\PostDepartementGestionModificationRedirection;
use WebDirectory\appli\app\actions\gestionDonnees\PostDepartementGestionSuppression;
use WebDirectory\appli\app\actions\gestionDonnees\PostEntreeCreate;
use WebDirectory\appli\app\actions\gestionDonnees\PostEntreeExport;
use WebDirectory\appli\app\actions\gestionDonnees\PostEntreeExportCSV;
use WebDirectory\appli\app\actions\gestionDonnees\PostEntreeExportPDF;
use WebDirectory\appli\app\actions\gestionDonnees\PostEntreeGestionModification;
use WebDirectory\appli\app\actions\gestionDonnees\PostEntreeGestionModificationRedirection;
use WebDirectory\appli\app\actions\gestionDonnees\PostEntreeGestionPublication;
use WebDirectory\appli\app\actions\gestionDonnees\PostEntreeGestionSuppression;
use WebDirectory\appli\app\actions\gestionDonnees\PostEntreeImportCSV;

return function( \Slim\App $app): \Slim\App {


    $app->get('/', function (Request $request, Response $response, array $args) {

        $texte = "Bienvenue sur l'application de gestion des entrées";

        if(isset($_SESSION['user'])){
            $user = $_SESSION['user'];
            $texte = "Bienvenue ".$user['email']." sur l'application de gestion des entrées";
        }

        $view = Twig::fromRequest($request);
        return $view->render($response, 'VueHome.twig', ['texte' => $texte, 'connecte'=> isset($_SESSION['user'])]);
    })->setName('home');

    $app->get('/entree/create[/]', GetEntreeCreate::class)->setName('getEntreeCreate');

    $app->post('/entree/create[/]', PostEntreeCreate::class)->setName('postEntreeCreate');

    $app->get('/departement/create[/]', GetDepartementCreate::class)->setName('getDepartementCreate');

    $app->post('/departement/create[/]', PostDepartementCreate::class)->setName('postDepartementCreate');

    $app->get('/entrees[/]', GetEntreesAffichage::class)->setName('getEntreesAffichage');

    $app->get('/departements[/]', GetDepartementsAffichage::class)->setName('getDepartementsAffichage');

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

    $app->post('/departement/suppression[/]', PostDepartementGestionSuppression::class )->setName('gestionSuppressionDepartement');

    $app->post('/entreeModificationRedirection[/]', PostEntreeGestionModificationRedirection::class)->setName('postEntreeModificationRedirection');

    $app->post('/entree/export[/]', PostEntreeExport::class)->setName('postEntreeExport');

    $app->post('/entree/importCSV[/]', PostEntreeImportCSV::class)->setName('postEntreeImportCSV');

    $app->get('/departement/modification[/]', GetDepartementGestionModification::class)->setName('getDepartementModification');

    $app->post('/departement/modification[/]', PostDepartementGestionModification::class)->setName('postDepartementModification');

    $app->post('/departementModificationRedirection[/]', PostDepartementGestionModificationRedirection::class)->setName('postDepartementModificationRedirection');

    return $app;

};