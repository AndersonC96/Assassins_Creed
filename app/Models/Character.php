<?php

declare(strict_types=1);

namespace App\Models;

/**
 * Character Model
 * 
 * Handles character data.
 * Loads from JSON data source.
 * 
 * @package App\Models
 */
class Character
{
    private array $categories;

    public function __construct()
    {
        $dataPath = dirname(__DIR__) . '/Data/characters.json';
        if (file_exists($dataPath)) {
            $this->categories = json_decode(file_get_contents($dataPath), true);
        } else {
            $this->categories = [];
        }
    }

    /**
     * Get all characters organized by category
     */
    public function getAllByCategory(): array
    {
        return $this->categories;
    }

    /**
     * Get categories metadata
     */
    public function getCategories(): array
    {
        $meta = [];
        foreach ($this->categories as $key => $cat) {
            $meta[$key] = [
                'titulo' => $cat['titulo'],
                'desc' => $cat['desc'],
                'icon' => $cat['icon'] ?? 'bi-person',
            ];
        }
        return $meta;
    }
}
