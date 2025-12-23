<?php

namespace App\Models;

use App\Core\Database;

class Video
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getRandomVideo(): ?array
    {
        // Fetch a random video from the database
        $sql = "SELECT * FROM videos ORDER BY RAND() LIMIT 1";
        $results = $this->db->query($sql);

        return $results[0] ?? null;
    }
    
    public function getAllVideos(): array
    {
        return $this->db->query("SELECT * FROM videos");
    }
}
