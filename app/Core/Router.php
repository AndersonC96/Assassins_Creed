<?php

declare(strict_types=1);

namespace App\Core;

/**
 * Simple Router
 * 
 * Maps URLs to controller actions.
 * 
 * @package App\Core
 */
class Router
{
    private array $routes = [];

    public function __construct()
    {
        $this->registerRoutes();
    }

    /**
     * Register all application routes
     */
    private function registerRoutes(): void
    {
        // Home
        $this->addRoute('', 'HomeController', 'index');
        $this->addRoute('home', 'HomeController', 'index');
        
        // Games
        $this->addRoute('games', 'GamesController', 'index');
        $this->addRoute('games/show', 'GamesController', 'show');
        
        // Characters
        $this->addRoute('characters', 'CharactersController', 'index');
        
        // Timeline
        $this->addRoute('timeline', 'TimelineController', 'index');
        
        // Media (Books)
        $this->addRoute('media', 'MediaController', 'index');
        $this->addRoute('books', 'MediaController', 'index');
        
        // Error pages
        $this->addRoute('404', 'ErrorController', 'notFound');
    }

    /**
     * Add a route
     * 
     * @param string $path URL path
     * @param string $controller Controller class name
     * @param string $action Method name
     */
    public function addRoute(string $path, string $controller, string $action): void
    {
        $this->routes[$path] = [
            'controller' => $controller,
            'action' => $action,
        ];
    }

    /**
     * Dispatch the request to appropriate controller
     * 
     * @param string $url Request URL
     */
    public function dispatch(string $url): void
    {
        // Clean URL
        $url = trim($url, '/');
        $url = filter_var($url, FILTER_SANITIZE_URL);
        
        // Parse URL for parameters
        $segments = explode('/', $url);
        $path = $segments[0] ?? '';
        
        // Check for game details route (games/ID or games/show/ID)
        if (count($segments) >= 2 && $segments[0] === 'games' && is_numeric($segments[1])) {
            $_GET['id'] = (int) $segments[1];
            $path = 'games/show';
        } elseif (count($segments) >= 3 && $segments[0] === 'games' && $segments[1] === 'show' && is_numeric($segments[2])) {
            $_GET['id'] = (int) $segments[2];
            $path = 'games/show';
        }
        
        // Find matching route
        if (isset($this->routes[$path])) {
            $route = $this->routes[$path];
            $this->callController($route['controller'], $route['action']);
        } else {
            // 404 Not Found
            $this->callController('ErrorController', 'notFound');
        }
    }

    /**
     * Call a controller action
     * 
     * @param string $controllerName Controller class name
     * @param string $action Method name
     */
    private function callController(string $controllerName, string $action): void
    {
        $controllerClass = "App\\Controllers\\{$controllerName}";
        
        if (!class_exists($controllerClass)) {
            throw new \RuntimeException("Controller {$controllerClass} not found");
        }
        
        $controller = new $controllerClass();
        
        if (!method_exists($controller, $action)) {
            throw new \RuntimeException("Action {$action} not found in {$controllerClass}");
        }
        
        $controller->$action();
    }
}
