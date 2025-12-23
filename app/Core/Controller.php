<?php

declare(strict_types=1);

namespace App\Core;

/**
 * Base Controller
 * 
 * All controllers extend this class.
 * 
 * @package App\Core
 */
abstract class Controller
{
    protected App $app;
    protected array $data = [];

    public function __construct()
    {
        $this->app = App::getInstance();
    }

    /**
     * Render a view
     * 
     * @param string $view View path (e.g., 'home/index')
     * @param array $data Data to pass to view
     * @param bool $withLayout Whether to include header/footer
     */
    protected function view(string $view, array $data = [], bool $withLayout = true): void
    {
        // Merge data
        $this->data = array_merge($this->data, $data);
        
        // Extract data to variables
        extract($this->data);
        
        // Set default page variables
        $pageTitle = $pageTitle ?? 'AC Database';
        $activePage = $activePage ?? '';
        
        // Build view path
        $viewPath = $this->app->config('paths.views') . $view . '.php';
        
        if (!file_exists($viewPath)) {
            throw new \RuntimeException("View {$view} not found at {$viewPath}");
        }
        
        if ($withLayout) {
            // Include header
            include $this->app->config('paths.views') . 'layouts/header.php';
            
            // Include navbar
            include $this->app->config('paths.views') . 'layouts/navbar.php';
            
            // Start main content
            echo '<main id="content">';
        }
        
        // Include main view
        include $viewPath;
        
        if ($withLayout) {
            // Close main content
            echo '</main>';
            
            // Include footer
            include $this->app->config('paths.views') . 'layouts/footer.php';
        }
    }

    /**
     * Redirect to another URL
     * 
     * @param string $url URL to redirect to
     */
    protected function redirect(string $url): void
    {
        $baseUrl = $this->app->config('app.url');
        header("Location: {$baseUrl}/{$url}");
        exit;
    }

    /**
     * Get configuration value
     * 
     * @param string $key Config key
     * @param mixed $default Default value
     * @return mixed
     */
    protected function config(string $key, mixed $default = null): mixed
    {
        return $this->app->config($key, $default);
    }

    /**
     * Get request parameter
     * 
     * @param string $key Parameter name
     * @param mixed $default Default value
     * @return mixed
     */
    protected function input(string $key, mixed $default = null): mixed
    {
        return $_GET[$key] ?? $_POST[$key] ?? $default;
    }
}
