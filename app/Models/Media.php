<?php

declare(strict_types=1);

namespace App\Models;

/**
 * Media Model
 * 
 * Handles books, comics, films, and other media.
 * Loads from JSON data source.
 * 
 * @package App\Models
 */
class Media
{
    private array $data;

    public function __construct()
    {
        $dataPath = dirname(__DIR__) . '/Data/media.json';
        if (file_exists($dataPath)) {
            $this->data = json_decode(file_get_contents($dataPath), true);
        } else {
            $this->data = ['romances' => [], 'comics' => [], 'filmes' => [], 'outros' => []];
        }
    }

    public function getRomances(): array
    {
        return $this->data['romances'] ?? [];
    }

    public function getComics(): array
    {
        return $this->data['comics'] ?? [];
    }

    public function getFilms(): array
    {
        return $this->data['filmes'] ?? [];
    }

    public function getOthers(): array
    {
        return $this->data['outros'] ?? [];
    }
}
