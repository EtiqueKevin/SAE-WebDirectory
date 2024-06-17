<?php

use WebDirectory\appli\infrastructure\Eloquent;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

session_start();

$app = AppFactory::create();

$twig = Twig::create(__DIR__ . '/../app/views', ['cache' => false]);
$app->add(TwigMiddleware::create($app, $twig));

$app->addRoutingMiddleware();

$app->addErrorMiddleware(true, false, false);

$app= (require_once __DIR__ . '/routes.php')($app);

Eloquent::init('../src/conf/webdirectory.db.conf.ini.dist');

return $app;