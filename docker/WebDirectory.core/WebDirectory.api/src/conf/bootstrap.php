<?php

use webdirectory\api\infrastructure\Eloquent;
use Slim\Factory\AppFactory;

$app = AppFactory::create();

$app->addRoutingMiddleware();

$app->addErrorMiddleware(true, false, false);

$app= (require_once __DIR__ . '/routes.php')($app);

Eloquent::init(__DIR__ . '/gift.db.conf.ini.dist');

//CORS
$app->add(function ($request, $handler) {
    $response = $handler->handle($request);
    return $response
        ->withHeader('Access-Control-Allow-Origin', '*')
        ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});

return $app;