<?php
/**
 * Front Controller & PSR-4 Autoloader
 */

// Define workspace roots (Tự động nhận diện thư mục app)
if (is_dir(__DIR__ . '/app')) {
    define('ROOT_PATH', realpath(__DIR__));
} elseif (is_dir(__DIR__ . '/../2fa/app')) {
    define('ROOT_PATH', realpath(__DIR__ . '/../2fa'));
} elseif (is_dir(__DIR__ . '/../app')) {
    define('ROOT_PATH', realpath(__DIR__ . '/..'));
} else {
    define('ROOT_PATH', realpath(__DIR__));
}
define('APP_PATH', ROOT_PATH . '/app');
define('BASE_URL', str_replace('\\', '/', rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\')));

// 1. PSR-4 Autoloader Implementation
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $base_dir = APP_PATH . '/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

// 2. Initialize Routing & Config
use App\Core\Router;

$router = new Router();

// Load Config
$configFile = ROOT_PATH . '/config/config.php';
$config = file_exists($configFile) ? require $configFile : [];

// 3. Define Routes
$router->add('GET', '/', \App\Controllers\HomeController::class, 'index');
$router->add('GET', '/index.php', \App\Controllers\HomeController::class, 'index');
$router->add('GET', '/blog', \App\Controllers\BlogController::class, 'index');
$router->add('GET', '/blog/{slug}', \App\Controllers\BlogController::class, 'detail');
$router->add('GET', '/about', \App\Controllers\HomeController::class, 'about');
$router->add('GET', '/privacy', \App\Controllers\HomeController::class, 'privacy');
$router->add('GET', '/terms', \App\Controllers\HomeController::class, 'terms');
$router->add('GET', '/contact', \App\Controllers\HomeController::class, 'contact');
$router->add('POST', '/api/generate', \App\Controllers\HomeController::class, 'generateApi');
$router->add('POST', '/api/contact', \App\Controllers\HomeController::class, 'contactApi');

// 4. Dispatch Request
$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

// Strip subdirectories if hosting inside a subfolder (e.g. localhost/website_2fa_2fa/...)
// We can strip path segments up to public/ to make it work in any directory structure!
$scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
$baseDir = str_replace('\\', '/', dirname($scriptName));

if (in_array(basename($scriptName), ['index.php', 'router.php']) && $baseDir !== '/' && $baseDir !== '.' && strpos($requestUri, $baseDir) === 0) {
    $requestUri = substr($requestUri, strlen($baseDir));
}

// Dispatch
$router->dispatch($requestUri, $requestMethod);
