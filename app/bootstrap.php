<?php

use Doctrine\Common\Cache\Psr6\DoctrineProvider;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Dotenv\Dotenv;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();
print_r($_ENV);

$isDevMode = $_ENV['APP_DEBUG'] === 'true';
date_default_timezone_set($_ENV['APP_TIMEZONE'] ?? 'UTC');
$entityPaths = [__DIR__ . '/../App/Models'];
$dbParams = require_once __DIR__ . '/../config/database.php';

$cache = DoctrineProvider::wrap(new ArrayAdapter());

$config = ORMSetup::createAttributeMetadataConfiguration(
    $entityPaths,
    $isDevMode,
    null,
    $cache,
    false
);

$entityManager = new EntityManager($dbParams, $config);

if (isset($_ENV['APP_DEBUG']) && $_ENV['APP_DEBUG'] === 'true') {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);
}

set_exception_handler(function (\Throwable $exception) {
    http_response_code(500);
    header('Content-Type: application/json; charset=UTF-8');
    $error = [
        'success' => false,
        'message' => 'Internal Server Error',
    ];
    if (isset($_ENV['APP_DEBUG']) && $_ENV['APP_DEBUG'] === 'true') {
        $error['error_details'] = [
            'message' => $exception->getMessage(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'trace' => $exception->getTraceAsString(),
        ];
    }
    echo json_encode($error);
    exit;
});

define('BASE_PATH', dirname(__DIR__));
