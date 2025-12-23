<?php

declare(strict_types=1);

namespace App\Models;

/**
 * Game Model
 * 
 * Handles game data and categories.
 * 
 * @package App\Models
 */
class Game
{
    private ApiClient $api;

    /**
     * Game categories with IGDB IDs
     */
    private array $categories = [
        'principal' => [
            'titulo' => 'Série Principal',
            'desc' => 'Os títulos principais da saga Assassin\'s Creed',
            'ids' => [128, 127, 125, 126, 7336, 11118, 538, 15, 9364, 533, 7334, 970, 119171, 26845, 217590]
        ],
        'spinoffs' => [
            'titulo' => 'Spin-offs e Portáteis',
            'desc' => 'Jogos derivados e versões para plataformas portáteis',
            'ids' => [2093, 2094, 4854, 4855, 4856, 9789, 14160, 9608, 11245, 13715, 2464, 217597]
        ],
        'remastered' => [
            'titulo' => 'Remasters',
            'desc' => 'Versões remasterizadas dos títulos clássicos',
            'ids' => [19457, 111296, 136393]
        ],
        'colecoes' => [
            'titulo' => 'Coletâneas e Relançamentos',
            'desc' => 'Compilações e edições especiais',
            'ids' => [36829, 25905, 133341, 110554, 132196, 111098]
        ],
        'cancelados' => [
            'titulo' => 'Cancelados e Descontinuados',
            'desc' => 'Projetos que não chegaram ao lançamento',
            'ids' => [27508, 80948, 165182, 165192, 137920]
        ],
        'embreve' => [
            'titulo' => 'Em Breve',
            'desc' => 'Próximos lançamentos da franquia',
            'ids' => [216319, 216321]
        ]
    ];

    public function __construct()
    {
        $this->api = new ApiClient();
    }

    /**
     * Get all categories
     * 
     * @return array
     */
    public function getCategories(): array
    {
        return $this->categories;
    }

    /**
     * Get all game IDs
     * 
     * @return array
     */
    public function getAllIds(): array
    {
        $allIds = [];
        foreach ($this->categories as $cat) {
            $allIds = array_merge($allIds, $cat['ids']);
        }
        return array_unique($allIds);
    }

    /**
     * Get all games organized by category
     * 
     * @return array
     */
    public function getAllByCategory(): array
    {
        $allIds = $this->getAllIds();
        $fields = 'id, name, cover.url, first_release_date, platforms.abbreviation, aggregated_rating, videos.video_id';
        
        $games = $this->api->getGamesByIds($allIds, $fields);
        
        // Index by ID
        $gamesById = [];
        foreach ($games as $game) {
            $gamesById[$game['id']] = $game;
        }
        
        // Organize by category
        $result = [];
        foreach ($this->categories as $key => $cat) {
            $result[$key] = [
                'titulo' => $cat['titulo'],
                'desc' => $cat['desc'],
                'games' => []
            ];
            
            foreach ($cat['ids'] as $id) {
                if (isset($gamesById[$id])) {
                    $result[$key]['games'][] = $gamesById[$id];
                }
            }
            
            // Sort by release date
            usort($result[$key]['games'], function ($a, $b) {
                $dateA = $a['first_release_date'] ?? PHP_INT_MAX;
                $dateB = $b['first_release_date'] ?? PHP_INT_MAX;
                return $dateA <=> $dateB;
            });
        }
        
        return $result;
    }

    /**
     * Get single game by ID
     * 
     * @param int $id
     * @return array|null
     */
    public function find(int $id): ?array
    {
        return $this->api->getGameById($id);
    }

    /**
     * Get rating color based on score
     * 
     * @param float|null $rating
     * @return string CSS color
     */
    public static function getRatingColor(?float $rating): string
    {
        if ($rating === null) {
            return '#888';
        }
        if ($rating >= 75) {
            return '#4CAF50';
        }
        if ($rating >= 50) {
            return '#FFC107';
        }
        return '#f44336';
    }
}
