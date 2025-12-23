<?php
$host = 'localhost';
$db   = 'assassins_creed'; // Trying the existing DB
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    echo "Connected to 'assassins_creed'.\n";
    
    $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    echo "Tables: " . implode(', ', $tables) . "\n";
    
    if (in_array('videos', $tables)) {
        echo "--- Table 'videos' columns ---\n";
        $columns = $pdo->query("SHOW COLUMNS FROM videos")->fetchAll(PDO::FETCH_ASSOC);
        foreach ($columns as $col) echo $col['Field'] . "\n";
        
        echo "--- First Video ---\n";
        print_r($pdo->query("SELECT * FROM videos LIMIT 1")->fetch(PDO::FETCH_ASSOC));
    }
    
     if (in_array('games', $tables)) {
        echo "--- Table 'games' columns ---\n";
        $columns = $pdo->query("SHOW COLUMNS FROM games")->fetchAll(PDO::FETCH_ASSOC);
        foreach ($columns as $col) echo $col['Field'] . "\n";
    }

} catch (\PDOException $e) {
    echo "Error: " . $e->getMessage();
}
