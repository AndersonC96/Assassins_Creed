<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\App;

/**
 * Timeline Model
 * 
 * Handles historical and release timeline data.
 * Loads from JSON data source.
 * 
 * @package App\Models
 */
class Timeline
{
    private array $data;

    public function __construct()
    {
        $dataPath = dirname(__DIR__) . '/Data/timeline.json';
        if (file_exists($dataPath)) {
            $this->data = json_decode(file_get_contents($dataPath), true);
        } else {
            $this->data = ['historica' => [], 'lancamentos' => [], 'eras' => []];
        }
    }

    /**
     * Get historical timeline (in-universe events)
     */
    public function getHistorical(): array
    {
        return $this->data['historica'] ?? [];
    }

    /**
     * Get release timeline (game releases)
     */
    public function getReleases(): array
    {
        return $this->data['lancamentos'] ?? [];
    }

    /**
     * Get era definitions
     */
    public function getEras(): array
    {
        return $this->data['eras'] ?? [];
    }
}
