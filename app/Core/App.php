<?php

declare(strict_types=1);

namespace App\Core;

/**
 * Main Application Bootstrap
 * 
 * Initializes the application, loads configuration and starts routing.
 * 
 * @package App\Core
 */
class App
{
    private static ?App $instance = null;
    private array $config = [];
    private Router $router;

    /**
     * Private constructor (Singleton pattern)
     */
    private function __construct()
    {
        $this->loadConfig();
        $this->router = new Router();
    }

    /**
     * Get singleton instance
     */
    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Load configuration file
     */
    private function loadConfig(): void
    {
        $configPath = dirname(__DIR__, 2) . '/config/config.php';
        if (file_exists($configPath)) {
            $this->config = require $configPath;
        }
    }

    /**
     * Get configuration value
     * 
     * @param string $key Dot notation key (e.g., 'igdb.client_id')
     * @param mixed $default Default value if key not found
     * @return mixed
     */
    public function config(string $key, mixed $default = null): mixed
    {
        $keys = explode('.', $key);
        $value = $this->config;

        foreach ($keys as $k) {
            if (!isset($value[$k])) {
                return $default;
            }
            $value = $value[$k];
        }

        return $value;
    }

    /**
     * Get router instance
     */
    public function getRouter(): Router
    {
        return $this->router;
    }

    /**
     * Run the application
     */
    public function run(): void
    {
        $url = $_GET['url'] ?? '';
        $this->router->dispatch($url);
    }
}
