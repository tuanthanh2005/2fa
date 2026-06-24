<?php
namespace App\Core;

class Controller {
    /**
     * Render a view layout
     *
     * @param string $view View file name (relative to app/Views/)
     * @param array $data Data to be passed to the view
     */
    protected function render($view, $data = []) {
        // Fetch config inside view
        $config = require __DIR__ . '/../../config/config.php';
        
        // Extract variables to view scope
        extract($data);

        // Capture view content
        ob_start();
        $viewFile = __DIR__ . '/../Views/' . $view . '.php';
        if (file_exists($viewFile)) {
            require $viewFile;
        } else {
            echo "View $view not found.";
        }
        $content = ob_get_clean();

        // Render main layout
        require __DIR__ . '/../Views/layout.php';
    }

    /**
     * Return JSON response
     *
     * @param array|object $data The response data
     * @param int $status HTTP status code
     */
    protected function json($data, $status = 200) {
        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        exit;
    }
}
