<?php
/**
 * Application Configuration
 * 
 * @package App\Config
 */

return [
    // Application Settings
    'app' => [
        'name' => 'Assassin\'s Creed Database',
        'version' => '2.0.0',
        'url' => 'http://localhost/Assassins_Creed/public',
        'debug' => true,
    ],
    
    // IGDB API Settings
    'igdb' => [
        'client_id' => 'dytp463ksb6k09r6e4nqkhp6u8gt62',
        'access_token' => 'l6p3tnk3677zj5qdtlz095pngs48jn',
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
