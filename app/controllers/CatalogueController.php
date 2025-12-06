<?php
namespace App\Controllers;

use Core\View;
use App\Models\CatalogueModel;

class CatalogueController {
    public function index() {
        try {
            // Fetch catalogue items and categories from the model
            $model = new CatalogueModel();
            $items = $model->getItems();
            $categories = $model->getCategories();
            
            // Debugging: uncomment to see data
            // echo "<pre>Items: "; print_r($items); echo "</pre>";
            // echo "<pre>Categories: "; print_r($categories); echo "</pre>";
            // exit;
            
            // Pass items and categories to the view for rendering
            View::render('catalogue/index', [
                'items' => $items,
                'categories' => $categories
            ]);
        } catch (\Exception $e) {
            // Show error message
            echo "<div style='padding: 2rem; max-width: 800px; margin: 2rem auto; background: #ffe5e5; border-left: 4px solid #ef4444; border-radius: 8px;'>";
            echo "<h2>Database Error</h2>";
            echo "<p><strong>Error:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
            echo "<p><strong>File:</strong> " . $e->getFile() . " (Line " . $e->getLine() . ")</p>";
            echo "<hr>";
            echo "<h3>Troubleshooting Steps:</h3>";
            echo "<ol>";
            echo "<li>Check if database is imported: <a href='/test_db.php'>Test Database Connection</a></li>";
            echo "<li>Verify credentials in <code>config/config.php</code></li>";
            echo "<li>Ensure MySQL service is running</li>";
            echo "</ol>";
            echo "</div>";
            exit;
        }
    }
}
?>
