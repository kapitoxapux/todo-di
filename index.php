<?php

require __DIR__ . '/vendor/autoload.php';

use App\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Controllers\TaskController;
use App\Controllers\UserController;

$routes = [
    '/' => [
        'controller' => TaskController::class,
        'action' => 'index'
    ],
    '/create' => [
        'controller' => TaskController::class,
        'action' => 'create'
    ],
    '/message' => [
        'controller' => TaskController::class,
        'action' => 'message'
    ],
    '/update' => [
        'controller' => TaskController::class,
        'action' => 'update'
    ],
    '/change' => [
        'controller' => TaskController::class,
        'action' => 'change'
    ],
    '/login' => [
        'controller' => UserController::class,
        'action' => 'index'
    ],
    '/logout' => [
        'controller' => UserController::class,
        'action' => 'logout'
    ],
    '/auth' => [
        'controller' => UserController::class,
        'action' => 'login'
    ],
];

$request = Request::createFromGlobals();
$path = $request->getPathInfo();

if (!isset($routes[$path])) {
    $response = new Response('Not Found', 404);
} else {
    $action = Application::getInstance()->get($routes[$path]['controller'])->handler($request, $routes[$path]['action']);
    $response = new Response($action);
}

$response->send();
