<?php
class Router {
    private $routes = [];
    private $middlewares = [];
    
    public function get($path, $callback, $middleware = null) {
        $this->routes['GET'][$path] = $callback;
        if ($middleware) {
            $this->middlewares['GET'][$path] = $middleware;
        }
    }
    
    public function post($path, $callback, $middleware = null) {
        $this->routes['POST'][$path] = $callback;
        if ($middleware) {
            $this->middlewares['POST'][$path] = $middleware;
        }
    }
    
    public function dispatch() {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = $this->getCurrentPath();
        
        // Handle static files
        if (strpos($path, '/public/') === 0) {
            return false; // Let the web server handle static files
        }
        
        if (isset($this->routes[$method][$path])) {
            // Check middleware
            if (isset($this->middlewares[$method][$path])) {
                $middlewareResult = $this->executeMiddleware($this->middlewares[$method][$path]);
                if (!$middlewareResult) {
                    return;
                }
            }
            
            $callback = $this->routes[$method][$path];
            $this->executeCallback($callback);
        } else {
            $this->show404();
        }
    }
    
    private function getCurrentPath() {
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $basePath = BASE_PATH;
        
        if (strpos($path, $basePath) === 0) {
            $path = substr($path, strlen($basePath));
        }
        
        if (empty($path) || $path === '/') {
            $path = '/';
        }
        
        return $path;
    }
    
    private function executeCallback($callback) {
        if (is_string($callback)) {
            list($controller, $method) = explode('@', $callback);
            $controllerFile = "app/controllers/{$controller}.php";
            
            if (file_exists($controllerFile)) {
                require_once $controllerFile;
                if (class_exists($controller)) {
                    $controllerInstance = new $controller();
                    if (method_exists($controllerInstance, $method)) {
                        $controllerInstance->$method();
                    } else {
                        $this->show404();
                    }
                } else {
                    $this->show404();
                }
            } else {
                $this->show404();
            }
        }
    }
    
    private function executeMiddleware($middleware) {
        // Simple auth middleware
        if ($middleware === 'auth') {
            if (!isset($_SESSION['user_id'])) {
                header('Location: /login');
                exit;
            }
        }
        return true;
    }
    
    private function show404() {
        http_response_code(404);
        include 'app/views/errors/404.php';
    }
}
?>
