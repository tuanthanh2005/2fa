<?php
/**
 * Router for PHP built-in development server.
 * Usage: php -S 127.0.0.1:8000 -t public public/router.php
 */

// Serve static files directly (css, js, images, etc.)
$requestUri = $_SERVER['REQUEST_URI'];
$filePath = __DIR__ . parse_url($requestUri, PHP_URL_PATH);

if (is_file($filePath)) {
    return false; // Let PHP built-in server handle static files
}

$rootFilePath = __DIR__ . '/..' . parse_url($requestUri, PHP_URL_PATH);
if (is_file($rootFilePath)) {
    $mime = match(pathinfo($rootFilePath, PATHINFO_EXTENSION)) {
        'css' => 'text/css',
        'js' => 'application/javascript',
        'png' => 'image/png',
        'jpg', 'jpeg' => 'image/jpeg',
        'svg' => 'image/svg+xml',
        default => 'text/plain'
    };
    header("Content-Type: $mime");
    readfile($rootFilePath);
    exit;
}

// Route everything else through the main index.php
require_once __DIR__ . '/../index.php';
