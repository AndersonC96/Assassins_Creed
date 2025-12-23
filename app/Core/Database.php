<?php

namespace App\Core;

use PDO;
use PDOException;

class Database
{
    private static ?Database $instance = null;
    private PDO $connection;

    private function __construct()
    {
        // Load config if helper is available, otherwise user env directly or hardcode fallback
        // Assuming config.php is loaded or we can access env() global helper if defined in public/index.php
        // A safer bet is to rely on config array passed or reload it.
        // For simplicity in this project structure, we'll load config.
        
        $config = require __DIR__ . '/../../config/config.php';
        $dbConfig = $config['database'];
        
        // Override with Env if available and not set in config array logic (config.php usually handles env)
        // In our config.php, 'name' => 'ac_database', we want 'assassins_creed'.
        // We will prefer the properly updated .env values if our config.php reads them.
        
        $host = env('DB_HOST', 'localhost');
        $db   = env('DB_DATABASE', 'assassins_creed');
        $user = env('DB_USERNAME', 'root');
        $pass = env('DB_PASSWORD', '');
        $charset = 'utf8mb4';

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $this->connection = new PDO($dsn, $user, $pass, $options);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    public static function getInstance(): Database
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection(): PDO
    {
        return $this->connection;
    }
    
    // Helper for simple queries
    public function query(string $sql, array $params = []): array
    {
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
}
