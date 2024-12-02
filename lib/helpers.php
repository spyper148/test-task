<?php

use Psr\Http\Message\ResponseInterface;
use Slim\App;
use Slim\Views\PhpRenderer;

if (!function_exists('view')) {
    function view(ResponseInterface $response, string $template, array $params = []): ResponseInterface
    {
        return (new PhpRenderer(__DIR__.'/../templates/'))
            ->render($response, $template, $params);

    }

    function routeParser(App $app, string $routeName, int $id): string
    {
        $routeParser = $app->getRouteCollector()->getRouteParser();
        return $routeParser->urlFor($routeName, ['post' => $id ]);
    }
}