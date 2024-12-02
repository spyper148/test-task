<?php

use Lib\Http\Controllers\PostController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;

return function (App $app) {
    $app->get('/',[PostController::class,'search']);
    $app->get('/comment',[PostController::class,'search'])->setName('comment');
};