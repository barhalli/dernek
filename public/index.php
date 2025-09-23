<?php
$router = require __DIR__ . '/../app/bootstrap.php';
$routes = require __DIR__ . '/../app/Config/routes.php';

foreach ($routes as $route) {
    $router->add($route['method'], $route['uri'], $route['action'], $route['middlewares'] ?? []);
}

$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI'] ?? '/');
