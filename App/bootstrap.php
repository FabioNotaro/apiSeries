<?php

//$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
//$dotenv->load();

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
        'message' => 'Erro interno no servidor',
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
date_default_timezone_set($_ENV['APP_TIMEZONE'] ?? 'UTC');
$dbConfig = require_once __DIR__ . '/Config/database.php';
define('BASE_PATH', dirname(__DIR__));
