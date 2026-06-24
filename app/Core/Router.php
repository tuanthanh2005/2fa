<?php
namespace App\Core;

class Router {
    protected $routes = [];

    /**
     * Add a route to the routing table
     *
     * @param string $method HTTP Method (GET, POST, etc.)
     * @param string $path URL path
     * @param string $controller Controller class name
     * @param string $action Controller method name
     */
    public function add($method, $path, $controller, $action) {
        $path = trim($path, '/');
        $this->routes[] = [
            'method' => strtoupper($method),
            'path' => $path === '' ? 'home' : $path,
            'controller' => $controller,
            'action' => $action
        ];
    }

    /**
     * Dispatch the route
     *
     * @param string $url The request URL
     * @param string $requestMethod The HTTP request method
     */
    public function dispatch($url, $requestMethod) {
        $url = parse_url($url, PHP_URL_PATH);
        $url = trim($url, '/');
        if ($url === '') {
            $url = 'home';
        }

        $requestMethod = strtoupper($requestMethod);

        foreach ($this->routes as $route) {
            if ($route['method'] === $requestMethod && $route['path'] === $url) {
                $controllerClass = $route['controller'];
                $action = $route['action'];

                if (class_exists($controllerClass)) {
                    $controller = new $controllerClass();
                    if (method_exists($controller, $action)) {
                        $controller->$action();
                        return;
                    }
                }
            }
        }

        // Default 404
        http_response_code(404);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['error' => 'Not Found', 'message' => 'Trang hoặc API yêu cầu không tồn tại.'], JSON_UNESCAPED_UNICODE);
    }
}
