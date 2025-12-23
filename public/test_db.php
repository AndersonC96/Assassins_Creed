<?php
$host = 'localhost';
$db   = 'ac_database';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    echo "Connected to MySQL server successfully.\n";
    
    // Check if database exists
    $stmt = $pdo->query("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$db'");
    if ($stmt->fetch()) {
        echo "Database '$db' exists.\n";
        $pdo->exec("USE $db");
        
        // List tables
        $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
        echo "Tables: " . implode(', ', $tables) . "\n";
        
        if (in_array('videos', $tables)) {
            echo "--- Table 'videos' columns ---\n";
            $columns = $pdo->query("SHOW COLUMNS FROM videos")->fetchAll();
            foreach ($columns as $col) echo $col['Field'] . " (" . $col['Type'] . ")\n";
            
            echo "--- First 3 videos ---\n";
            $rows = $pdo->query("SELECT * FROM videos LIMIT 3")->fetchAll();
            print_r($rows);
        }
        
        if (in_array('games', $tables)) {
             echo "--- Table 'games' columns ---\n";
            $columns = $pdo->query("SHOW COLUMNS FROM games")->fetchAll();
             foreach ($columns as $col) echo $col['Field'] . " (" . $col['Type'] . ")\n";
        }
    } else {
        echo "Database '$db' DOES NOT exist.\n";
        // Check what databases DO exist
        $dbs = $pdo->query("SHOW DATABASES")->fetchAll(PDO::FETCH_COLUMN);
        echo "Available Databases: " . implode(', ', $dbs) . "\n";
    }
    
} catch (\PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
