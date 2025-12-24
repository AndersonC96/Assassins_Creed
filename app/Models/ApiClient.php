<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\App;

/**
 * IGDB API Client
 * 
 * Handles all communication with the IGDB API.
 * 
 * @package App\Models
 */
class ApiClient
{
    private string $clientId;
    private string $accessToken;
    private string $baseUrl;

    public function __construct()
    {
        $app = App::getInstance();
        $this->clientId = $app->config('igdb.client_id', '');
        $this->accessToken = $app->config('igdb.access_token', '');
        $this->baseUrl = $app->config('igdb.base_url', 'https://api.igdb.com/v4/');
    }

    /**
     * Make a query to IGDB API with Caching
     * 
     * @param string $endpoint API endpoint (e.g., 'games')
     * @param string $body Query body
     * @param int $ttl Cache time to live in seconds (default 1 hour)
     * @return array|null Response data or null on error
     */
    public function query(string $endpoint, string $body, int $ttl = 3600): ?array
    {
        // Check Cache
        $cacheKey = md5($endpoint . $body);
        $cacheDir = dirname(__DIR__) . '/Data/cache/';
        $cacheFile = $cacheDir . $cacheKey . '.json';
        
        if (!is_dir($cacheDir)) {
            mkdir($cacheDir, 0777, true);
        }
        
        if (file_exists($cacheFile) && (time() - filemtime($cacheFile) < $ttl)) {
            return json_decode(file_get_contents($cacheFile), true);
        }
        
        // Execute Request
        $curl = curl_init();
        
        curl_setopt_array($curl, [
            CURLOPT_URL => $this->baseUrl . $endpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'Client-ID: ' . $this->clientId,
                'Authorization: Bearer ' . $this->accessToken,
                'Content-Type: text/plain',
            ],
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $body,
            CURLOPT_SSL_VERIFYPEER => false,
        ]);
        
        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        
        if ($httpCode !== 200 || !$response) {
            return null;
        }
        
        $data = json_decode($response, true);
        
        // Save Cache
        if (is_array($data)) {
            file_put_contents($cacheFile, $response);
            return $data;
        }
        
        return null;
    }

    /**
     * Get games by IDs
     * 
     * @param array $ids Game IDs
     * @param string $fields Fields to retrieve
     * @return array
     */
    public function getGamesByIds(array $ids, string $fields = '*'): array
    {
        if (empty($ids)) {
            return [];
        }
        
        $idsString = implode(',', $ids);
        $body = "fields {$fields}; where id = ({$idsString}); limit 100;";
        
        return $this->query('games', $body) ?? [];
    }

    /**
     * Get single game by ID
     * 
     * @param int $id Game ID
     * @return array|null
     */
    public function getGameById(int $id): ?array
    {
        $fields = 'id, name, summary, storyline, cover.url, ' .
                  // Screenshots and artworks
                  'screenshots.url, screenshots.image_id, artworks.url, artworks.image_id, ' .
                  // Videos
                  'videos.video_id, videos.name, ' .
                  // Release dates and platforms
                  'release_dates.date, release_dates.platform.abbreviation, platforms.abbreviation, platforms.name, ' .
                  // Genres, themes, game modes
                  'genres.name, themes.name, game_modes.name, ' .
                  // Companies
                  'involved_companies.company.name, involved_companies.developer, involved_companies.publisher, ' .
                  // Ratings
                  'aggregated_rating, aggregated_rating_count, rating, rating_count, ' .
                  // Age ratings - use wildcard to get all fields
                  'age_ratings.*, ' .
                  // Similar games
                  'similar_games.id, similar_games.name, similar_games.cover.url, similar_games.aggregated_rating, ' .
                  // Websites - use wildcard to get all fields
                  'websites.*';
        
        $body = "fields {$fields}; where id = {$id};";
        $result = $this->query('games', $body);
        
        return $result[0] ?? null;
    }

    /**
     * Get characters by game IDs
     * 
     * Fetches all characters associated with the given game IDs.
     * 
     * @param array $gameIds Game IDs to fetch characters for
     * @return array Characters data
     */
    public function getCharactersByGameIds(array $gameIds): array
    {
        if (empty($gameIds)) {
            return [];
        }
        
        $idsString = implode(',', $gameIds);
        $fields = 'id, name, description, akas, country_name, gender, species, slug, url, games, mug_shot.url, mug_shot.image_id';
        
        // Characters endpoint uses 'games' field to filter by game
        $body = "fields {$fields}; where games = ({$idsString}); limit 500;";
        
        return $this->query('characters', $body) ?? [];
    }

    /**
     * Get single character by ID
     * 
     * @param int $id Character ID
     * @return array|null Character data
     */
    public function getCharacterById(int $id): ?array
    {
        $fields = 'id, name, description, akas, country_name, gender, species, slug, url, games.id, games.name, mug_shot.url, mug_shot.image_id';
        
        $body = "fields {$fields}; where id = {$id};";
        $result = $this->query('characters', $body);
        
        return $result[0] ?? null;
    }

    /**
     * Search characters by name
     * 
     * @param string $name Character name to search
     * @param int $limit Result limit
     * @return array Characters matching the search
     */
    public function searchCharacters(string $name, int $limit = 50): array
    {
        $fields = 'id, name, description, akas, country_name, gender, games.id, games.name, mug_shot.url';
        $escapedName = addslashes($name);
        
        $body = "search \"{$escapedName}\"; fields {$fields}; limit {$limit};";
        
        return $this->query('characters', $body) ?? [];
    }
}

