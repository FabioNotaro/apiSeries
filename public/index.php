<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../App/bootstrap.php';

use App\Utils\Router;

header('Content-Type: application/json; charset=utf-8');

$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];
$requestUri = strtok($requestUri, '?');

$router = new Router;

require_once __DIR__ . '/../routes/api.php';

$route = $router->match($requestUri, $requestMethod);

if (!$route) {
    http_response_code(404 );
    echo json_encode([
        'success' => false,
        'message' => 'Not Found'
    ]);
    exit;
}

list($controllerClass, $method) = $route['action'];
$params = $route['params'];

if(!class_exists($controllerClass, true) && !method_exists($controllerClass, $method)) {
    http_response_code(500 );
    echo json_encode([
        'success' => false,
        'message' => 'Internal Server Error'
    ]);
    exit;
}

$controller = new $controllerClass();
$controller->$method($params);
