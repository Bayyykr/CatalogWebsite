<?php
// config/config.php
// Core configuration for the Catalogue MVC application

// Base URL (adjust if the app resides in a subdirectory)
// Base URL (adjust if the app resides in a subdirectory)
$scriptDir = dirname($_SERVER['SCRIPT_NAME']);
$scriptDir = str_replace('\\', '/', $scriptDir); // Normalize for Windows
define('BASE_URL', rtrim((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $scriptDir, '/') . '/');

// Database credentials (placeholder values)
define('DB_HOST', 'localhost');
define('DB_NAME', 'catalogue_db');
define('DB_USER', 'root');
define('DB_PASS', '');

// Autoloader for App and Core namespaces
spl_autoload_register(function ($class) {
    // Remove leading backslash if present
    $class = ltrim($class, '\\');
    $baseDir = __DIR__ . '/../app/';
    // Namespace prefix mappings
    $prefixes = [
        'App\\Controllers\\' => 'controllers/',
        'App\\Models\\'      => 'models/',
        'Core\\'               => 'core/',
    ];
    foreach ($prefixes as $prefix => $dir) {
        if (strpos($class, $prefix) === 0) {
            $relative = substr($class, strlen($prefix));
            $file = $baseDir . $dir . str_replace('\\', '/', $relative) . '.php';
            if (file_exists($file)) {
                require $file;
                return;
            }
        }
    }
    
    $file = $baseDir . str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) {
        require $file;
    }
});
?>
