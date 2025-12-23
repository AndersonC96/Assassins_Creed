<?php
/**
 * Application Configuration
 * 
 * @package App\Config
 */

// Simple .env parser (since we're not using vlucas/phpdotenv)
$envPath = __DIR__ . '/../.env';
$env = [];
if (file_exists($envPath)) {
    $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        list($key, $value) = explode('=', $line, 2);
        $env[trim($key)] = trim($value);
    }
}

function env($key, $default = null) {
    global $env;
    return $env[$key] ?? $default;
}

return [
    // Application Settings
    'app' => [
        'name' => env('APP_NAME', 'Assassin\'s Creed Database'),
        'version' => '2.0.0',
        'url' => env('APP_URL', 'http://localhost/Assassins_Creed/public'),
        'debug' => env('APP_DEBUG', true),
    ],
    
    // IGDB API Settings
    'igdb' => [
        'client_id' => env('IGDB_CLIENT_ID', 'dytp463ksb6k09r6e4nqkhp6u8gt62'),
        'access_token' => env('IGDB_ACCESS_TOKEN', 'l6p3tnk3677zj5qdtlz095pngs48jn'),
        'base_url' => 'https://api.igdb.com/v4/',
    ],
    
    // Database Settings (if needed in future)
    'database' => [
        'host' => 'localhost',
        'name' => 'ac_database',
        'user' => 'root',
        'pass' => '',
    ],
    
    // Paths
    'paths' => [
        'views' => __DIR__ . '/../app/Views/',
        'public' => __DIR__ . '/../public/',
    ],
];
