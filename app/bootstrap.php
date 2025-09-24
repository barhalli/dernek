<?php
use App\Core\Router;

spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $baseDir = __DIR__ . '/';
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }
    $relativeClass = substr($class, $len);
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';
    if (file_exists($file)) {
        require $file;
    }
});

require __DIR__ . '/Helpers/helpers.php';

$config = require __DIR__ . '/Config/config.php';
date_default_timezone_set($config['timezone']);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$router = new Router();
$router->setBasePath(dirname($_SERVER['SCRIPT_NAME'] ?? '') ?: '');

return $router;
