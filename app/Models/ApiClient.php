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
     * Make a query to IGDB API
     * 
     * @param string $endpoint API endpoint (e.g., 'games')
     * @param string $body Query body
     * @return array|null Response data or null on error
     */
    public function query(string $endpoint, string $body): ?array
    {
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
        
        return is_array($data) ? $data : null;
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
        $body = "fields {$fields}; where id = ({$idsString}); limit 50;";
        
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
        $fields = 'id, name, summary, storyline, cover.url, screenshots.url, videos.video_id, ' .
                  'release_dates.date, release_dates.platform.abbreviation, platforms.abbreviation, ' .
                  'platforms.name, genres.name, themes.name, game_modes.name, ' .
                  'involved_companies.company.name, involved_companies.developer, involved_companies.publisher, ' .
                  'aggregated_rating, aggregated_rating_count, rating, rating_count, ' .
                  'similar_games.name, similar_games.cover.url, websites.url, websites.category';
        
        $body = "fields {$fields}; where id = {$id};";
        $result = $this->query('games', $body);
        
        return $result[0] ?? null;
    }
}
