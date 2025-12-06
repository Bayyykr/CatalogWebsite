<?php
namespace Core;

class Router {
    private $routes = [];

    public function add($method, $path, $handler) {
        $this->routes[] = [$method, $path, $handler];
    }

    public function dispatch() {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        
        // Handle null case
        if ($requestUri === null) {
            $requestUri = '/';
        }
        
        // Collapse multiple slashes to a single slash
        $requestUri = preg_replace('#/+#', '/', $requestUri);
        
        // Ensure it starts with a single leading slash
        if ($requestUri[0] !== '/') {
            $requestUri = '/' . $requestUri;
        }
        
        // Normalize: remove trailing slash (except for root)
        if ($requestUri !== '/' && substr($requestUri, -1) === '/') {
            $requestUri = rtrim($requestUri, '/');
        }
        
        foreach ($this->routes as $route) {
            list($method, $path, $handler) = $route;
            if (strtoupper($method) !== $requestMethod) continue;
            
            $pattern = '#^' . preg_replace('#\\{[^/]+\\}#', '([^/]+)', $path) . '$#';
            if (preg_match($pattern, $requestUri, $matches)) {
                array_shift($matches); // remove full match
                
                // handler format: 'Controller@method'
                list($controller, $action) = explode('@', $handler);
                $controller = '\\App\\Controllers\\' . $controller;
                
                if (!class_exists($controller)) {
                    http_response_code(404);
                    echo "Controller $controller not found";
                    exit;
                }
                
                $instance = new $controller();
                if (!method_exists($instance, $action)) {
                    http_response_code(404);
                    echo "Method $action not found in $controller";
                    exit;
                }
                
                call_user_func_array([$instance, $action], $matches);
                return;
            }
        }
        
        // No route matched - debug info
        http_response_code(404);
        echo "Page not found. Request URI: " . htmlspecialchars($requestUri);
    }
}
