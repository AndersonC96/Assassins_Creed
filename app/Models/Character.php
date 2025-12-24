<?php

declare(strict_types=1);

namespace App\Models;

/**
 * Character Model
 * 
 * Handles character data from IGDB API and local JSON.
 * Uses a hybrid approach: API for images and base data,
 * local JSON for Portuguese descriptions and categorization.
 * 
 * @package App\Models
 */
class Character
{
    private ApiClient $api;
    private array $localData;
    private Game $gameModel;

    /**
     * Category definitions with icons
     */
    private array $categoryMeta = [
        'assassinos' => [
            'titulo' => 'Assassinos & Protagonistas',
            'desc' => 'Os heróis que carregam o legado da Irmandade através dos séculos',
            'icon' => 'bi-person-badge'
        ],
        'templarios' => [
            'titulo' => 'Templários Notáveis',
            'desc' => 'Os antagonistas que buscam ordem através do controle',
            'icon' => 'bi-shield-fill'
        ],
        'historicos' => [
            'titulo' => 'Personagens Históricos',
            'desc' => 'Figuras reais da história que cruzaram caminhos com os Assassinos',
            'icon' => 'bi-book'
        ],
        'modernos' => [
            'titulo' => 'Mundo Moderno',
            'desc' => 'Os protagonistas contemporâneos que revivem as memórias',
            'icon' => 'bi-cpu'
        ],
        'api' => [
            'titulo' => 'Outros Personagens',
            'desc' => 'Personagens adicionais da franquia obtidos via IGDB',
            'icon' => 'bi-people'
        ]
    ];

    public function __construct()
    {
        $this->api = new ApiClient();
        
        // Load local JSON data
        $dataPath = dirname(__DIR__) . '/Data/characters.json';
        if (file_exists($dataPath)) {
            $this->localData = json_decode(file_get_contents($dataPath), true);
        } else {
            $this->localData = [];
        }
        
        // Get game IDs from Game model
        $this->gameModel = new Game();
    }

    /**
     * Get all characters from IGDB API
     * 
     * @return array Characters from API
     */
    public function getAllFromApi(): array
    {
        $gameIds = $this->gameModel->getAllIds();
        return $this->api->getCharactersByGameIds($gameIds);
    }

    /**
     * Get all characters organized by category (hybrid approach)
     * 
     * Combines local curated data with API data for images
     * 
     * @return array Characters by category
     */
    public function getAllByCategory(): array
    {
        // Get API characters for images
        $apiCharacters = $this->getAllFromApi();
        $apiByName = [];
        foreach ($apiCharacters as $char) {
            $apiByName[strtolower($char['name'])] = $char;
        }
        
        // Build result from local data, enriching with API images
        $result = [];
        foreach ($this->localData as $catKey => $cat) {
            $result[$catKey] = [
                'titulo' => $cat['titulo'],
                'desc' => $cat['desc'],
                'icon' => $cat['icon'] ?? 'bi-person',
                'personagens' => []
            ];
            
            foreach ($cat['personagens'] as $person) {
                // Try to find matching API character for image
                $nameLower = strtolower($person['nome']);
                $apiMatch = $apiByName[$nameLower] ?? null;
                
                // Also try partial matches
                if (!$apiMatch) {
                    foreach ($apiByName as $apiName => $apiChar) {
                        if (strpos($apiName, explode(' ', $nameLower)[0]) === 0) {
                            $apiMatch = $apiChar;
                            break;
                        }
                    }
                }
                
                // Enrich with API data
                if ($apiMatch) {
                    $person['igdb_id'] = $apiMatch['id'];
                    if (isset($apiMatch['mug_shot']['url'])) {
                        $person['image'] = 'https:' . str_replace('t_thumb', 't_720p', $apiMatch['mug_shot']['url']);
                        $person['image_thumb'] = 'https:' . str_replace('t_thumb', 't_cover_big', $apiMatch['mug_shot']['url']);
                    }
                    if (empty($person['desc']) && isset($apiMatch['description'])) {
                        $person['desc_en'] = $apiMatch['description'];
                    }
                    // Remove from API list so we don't duplicate
                    unset($apiByName[$nameLower]);
                }
                
                $result[$catKey]['personagens'][] = $person;
            }
        }
        
        // Add remaining API characters that aren't in local data
        if (!empty($apiByName)) {
            $result['api'] = [
                'titulo' => $this->categoryMeta['api']['titulo'],
                'desc' => $this->categoryMeta['api']['desc'],
                'icon' => $this->categoryMeta['api']['icon'],
                'personagens' => []
            ];
            
            foreach ($apiByName as $apiChar) {
                $person = [
                    'nome' => $apiChar['name'],
                    'igdb_id' => $apiChar['id'],
                    'desc' => $apiChar['description'] ?? '',
                    'tipo' => $this->inferType($apiChar),
                    'nacionalidade' => $apiChar['country_name'] ?? 'Desconhecida',
                    'era' => 'Vários',
                    'jogo' => 'Assassin\'s Creed',
                ];
                
                if (isset($apiChar['mug_shot']['url'])) {
                    $person['image'] = 'https:' . str_replace('t_thumb', 't_720p', $apiChar['mug_shot']['url']);
                    $person['image_thumb'] = 'https:' . str_replace('t_thumb', 't_cover_big', $apiChar['mug_shot']['url']);
                }
                
                if (isset($apiChar['akas']) && is_array($apiChar['akas'])) {
                    $person['akas'] = $apiChar['akas'];
                }
                
                $result['api']['personagens'][] = $person;
            }
            
            // Only keep API category if it has characters
            if (empty($result['api']['personagens'])) {
                unset($result['api']);
            }
        }
        
        return $result;
    }

    /**
     * Get categories metadata
     * 
     * @return array Category metadata
     */
    public function getCategories(): array
    {
        $result = [];
        
        // Get categories from local data
        foreach ($this->localData as $key => $cat) {
            $result[$key] = [
                'titulo' => $cat['titulo'],
                'desc' => $cat['desc'],
                'icon' => $cat['icon'] ?? 'bi-person',
            ];
        }
        
        // Add API category if needed
        $apiChars = $this->getAllFromApi();
        $localNames = $this->getLocalCharacterNames();
        $hasExtraChars = false;
        
        foreach ($apiChars as $char) {
            if (!in_array(strtolower($char['name']), $localNames)) {
                $hasExtraChars = true;
                break;
            }
        }
        
        if ($hasExtraChars) {
            $result['api'] = $this->categoryMeta['api'];
        }
        
        return $result;
    }

    /**
     * Get character by ID (from API)
     * 
     * @param int $id Character ID
     * @return array|null Character data
     */
    public function find(int $id): ?array
    {
        return $this->api->getCharacterById($id);
    }

    /**
     * Search characters by name
     * 
     * @param string $query Search query
     * @return array Matching characters
     */
    public function search(string $query): array
    {
        return $this->api->searchCharacters($query);
    }

    /**
     * Get all local character names (lowercase)
     * 
     * @return array Names
     */
    private function getLocalCharacterNames(): array
    {
        $names = [];
        foreach ($this->localData as $cat) {
            foreach ($cat['personagens'] as $person) {
                $names[] = strtolower($person['nome']);
            }
        }
        return $names;
    }

    /**
     * Infer character type from API data
     * 
     * @param array $char API character data
     * @return string Inferred type
     */
    private function inferType(array $char): string
    {
        $name = strtolower($char['name'] ?? '');
        $desc = strtolower($char['description'] ?? '');
        
        if (strpos($desc, 'assassin') !== false || strpos($desc, 'hidden one') !== false) {
            return 'Assassino';
        }
        if (strpos($desc, 'templar') !== false || strpos($desc, 'order of the ancients') !== false) {
            return 'Templário';
        }
        if (strpos($desc, 'mentor') !== false) {
            return 'Mentor';
        }
        if (strpos($desc, 'historical') !== false || strpos($desc, 'real') !== false) {
            return 'Personagem Histórico';
        }
        
        return 'Personagem';
    }

    /**
     * Get gender label in Portuguese
     * 
     * @param int $gender IGDB gender code
     * @return string Gender label
     */
    public static function getGenderLabel(int $gender): string
    {
        return match ($gender) {
            0 => 'Masculino',
            1 => 'Feminino',
            2 => 'Outro',
            default => 'Desconhecido'
        };
    }
}
