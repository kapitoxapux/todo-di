<?php

require __DIR__ . '/vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$routes = [
    '/' => [
        'controller' => App\Controllers\TaskController::class,
        'action' => 'index'
    ],
    '/create' => [
        'controller' => App\Controllers\TaskController::class,
        'action' => 'create'
    ],
    '/message' => [
        'controller' => App\Controllers\TaskController::class,
        'action' => 'message'
    ],
    '/update' => [
        'controller' => App\Controllers\TaskController::class,
        'action' => 'update'
    ],
    '/change' => [
        'controller' => App\Controllers\TaskController::class,
        'action' => 'change'
    ],
    '/login' => [
        'controller' => App\Controllers\UserController::class,
        'action' => 'index'
    ],
    '/logout' => [
        'controller' => App\Controllers\UserController::class,
        'action' => 'logout'
    ],
    '/auth' => [
        'controller' => App\Controllers\UserController::class,
        'action' => 'login'
    ],
];

$request = Request::createFromGlobals();
$path = $request->getPathInfo();

if (!isset($routes[$path])) {
    $response = new Response('Not Found', 404);
} else {

    $action = (new App\Containers\Container())
        ->get($routes[$path]['controller'])
        ->handler($request, $routes[$path]['action'])
    ;

    $response = new Response($action);
}

$response->send();
