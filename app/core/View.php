<?php
namespace Core;

class View {
    /**
     * Render a view within the main layout.
     * @param string $viewPath Path relative to the views directory, e.g. 'home/index'
     * @param array $data Optional associative array of data to extract for the view.
     */
    public static function render(string $viewPath, array $data = []) {
        $viewFile = __DIR__ . '/../../app/views/' . $viewPath . '.php';
        if (!file_exists($viewFile)) {
            http_response_code(404);
            echo "View $viewPath not found";
            exit;
        }
        // Extract data variables for use in view
        extract($data);
        // Start output buffering to capture view content
        ob_start();
        include $viewFile;
        $content = ob_get_clean();
        // Include layout (header/footer) around content
        include __DIR__ . '/../../app/views/layout.php';
    }
}
?>
