<?php

use Slim\Psr7\Request;
use WebDirectory\appli\infrastructure\Eloquent;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;
use Slim\Psr7\Response as SlimResponse;

session_start();

$app = AppFactory::create();

$twig = Twig::create(__DIR__ . '/../app/views', ['cache' => false]);
$app->add(TwigMiddleware::create($app, $twig));

$app->addRoutingMiddleware();

$errorMiddleware = $app->addErrorMiddleware(true, false, false);

$errorMiddleware->setDefaultErrorHandler(
    function (Request $request, Throwable $exception, bool $displayErrorDetails, bool $logErrors, bool $logErrorDetails) use ($twig) {
        $statusCode = $exception->getCode();
        $errorMessage = $exception->getMessage();

        $response = new SlimResponse();

        return $twig->render($response, 'Error.twig', [
            'statusCode' => $statusCode,
            'errorMessage' => $errorMessage,
        ]);
    }
);

$app= (require_once __DIR__ . '/routes.php')($app);

Eloquent::init('../src/conf/webdirectory.db.conf.ini.dist');

return $app;