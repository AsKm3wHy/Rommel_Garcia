<?php
namespace Api\Core;

class Router {
    private $routes = [];

    public function __construct() {
        $this->registerRoutes();
    }

    private function registerRoutes() {
        $this->routes = [
            'appointments' => new \Api\Controllers\AppointmentController(),
            'users' => new \Api\Controllers\UserController(),
            // Add more controllers here
        ];
    }

    public function handleRequest() {
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $segments = explode('/', trim($path, '/'));
        
        if (!isset($segments[1]) || !isset($this->routes[$segments[1]])) {
            throw new \Exception('Invalid endpoint');
        }

        $controller = $this->routes[$segments[1]];
        $controller->processRequest($_SERVER['REQUEST_METHOD'], array_slice($segments, 2));
    }
}