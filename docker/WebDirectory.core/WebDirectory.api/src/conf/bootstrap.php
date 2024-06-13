<?php

use webdirectory\api\infrastructure\Eloquent;
use Slim\Factory\AppFactory;

$app = AppFactory::create();

$app->addRoutingMiddleware();

$app->addErrorMiddleware(true, false, false);

$app= (require_once __DIR__ . '/routes.php')($app);

Eloquent::init(__DIR__ . '/gift.db.conf.ini.dist');

return $app;