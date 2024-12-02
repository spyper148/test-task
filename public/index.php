<?php

use Lib\App;
use Slim\Factory\AppFactory;

require '../vendor/autoload.php';

App::configure();

$app = AppFactory::create();

(require '../app/routes/web.php')($app);

$app->run();

