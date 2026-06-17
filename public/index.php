<?php

define('BASE_PATH', dirname(__DIR__));
define('PUBLIC_PATH', __DIR__);

require_once BASE_PATH . '/vendor/autoload.php';
require_once BASE_PATH . '/src/helpers/env.php';
require_once BASE_PATH . '/src/helpers/functions.php';

loadEnv(BASE_PATH . '/.env');

session_start([
    'cookie_lifetime' => (int) env('SESSION_LIFETIME', 28800),
    'cookie_httponly' => true,
    'cookie_secure' => env('APP_ENV') === 'production',
]);

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

if ($uri !== '/' && file_exists(PUBLIC_PATH . $uri)) {
    return false;
}

$router = new App\Router();

require_once BASE_PATH . '/config/routes.php';

$router->dispatch($uri, $method);
