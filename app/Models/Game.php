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
            'desc' => 'Os títulos principais da saga',
            'ids' => [128, 127, 113, 537, 1266, 1970, 7570, 5606, 8263, 28540, 103054, 133004, 215060, 300976]
        ],
        'spinoffs' => [
            'titulo' => 'Spin-offs e Portáteis',
            'desc' => 'Jogos derivados e versões para plataformas portáteis',
            'ids' => [68526, 21349, 68527, 10661, 18865, 68528, 68529, 77209, 77265, 3195, 68530, 20077, 3775, 64759, 8223, 14902, 14903, 251353, 41030, 251568, 135506, 133962, 152231, 64737, 26917, 64765]
        ],
        'remastered' => [
            'titulo' => 'Remasters',
            'desc' => 'Versões remasterizadas dos títulos clássicos',
            'ids' => [20864, 81205, 109532, 109533]
        ],
        'colecoes' => [
            'titulo' => 'Coletâneas e Relançamentos',
            'desc' => 'Compilações e edições especiais',
            'ids' => [22754, 43015, 22815, 23954, 122236, 52416]
        ],
        'cancelados' => [
            'titulo' => 'Cancelados e Descontinuados',
            'desc' => 'Projetos que não chegaram ao lançamento',
            'ids' => [64737, 61278, 17028]
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

    /**
     * Get age rating organization name (ESRB, PEGI, etc.)
     * IGDB uses 'organization' field instead of 'category'
     */
    public static function getAgeRatingOrganization(int $organization): string
    {
        $organizations = [
            1 => 'ESRB',
            2 => 'PEGI',
            3 => 'CERO',
            4 => 'USK',
            5 => 'GRAC',
            6 => 'CLASS_IND',
            7 => 'ACB'
        ];
        return $organizations[$organization] ?? 'Unknown';
    }

    /**
     * Get age rating value label
     * IGDB uses 'rating_category' field instead of 'rating'
     */
    public static function getAgeRatingLabel(int $organization, int $ratingCategory): string
    {
        // ESRB ratings (rating_category values)
        $esrb = [
            6 => 'RP', 7 => 'EC', 8 => 'E', 9 => 'E10+', 
            10 => 'T', 11 => 'M', 12 => 'AO'
        ];
        // PEGI ratings (rating_category values)
        $pegi = [
            1 => '3', 2 => '7', 3 => '12', 4 => '16', 5 => '18'
        ];
        
        if ($organization === 1) return $esrb[$ratingCategory] ?? '?';
        if ($organization === 2) return $pegi[$ratingCategory] ?? '?';
        return (string) $ratingCategory;
    }

    /**
     * Get website type label and icon
     * IGDB uses 'type' field instead of 'category'
     */
    public static function getWebsiteInfo(int $type): array
    {
        $sites = [
            1 => ['label' => 'Oficial', 'icon' => 'bi-globe'],
            2 => ['label' => 'Wikia', 'icon' => 'bi-book'],
            3 => ['label' => 'Wikipedia', 'icon' => 'bi-wikipedia'],
            4 => ['label' => 'Facebook', 'icon' => 'bi-facebook'],
            5 => ['label' => 'Twitter', 'icon' => 'bi-twitter-x'],
            6 => ['label' => 'Twitch', 'icon' => 'bi-twitch'],
            8 => ['label' => 'Instagram', 'icon' => 'bi-instagram'],
            9 => ['label' => 'YouTube', 'icon' => 'bi-youtube'],
            10 => ['label' => 'iPhone', 'icon' => 'bi-apple'],
            11 => ['label' => 'iPad', 'icon' => 'bi-tablet'],
            12 => ['label' => 'Android', 'icon' => 'bi-android2'],
            13 => ['label' => 'Steam', 'icon' => 'bi-steam'],
            14 => ['label' => 'Reddit', 'icon' => 'bi-reddit'],
            15 => ['label' => 'Itch.io', 'icon' => 'bi-controller'],
            16 => ['label' => 'Epic Games', 'icon' => 'bi-controller'],
            17 => ['label' => 'GOG', 'icon' => 'bi-controller'],
            18 => ['label' => 'Discord', 'icon' => 'bi-discord'],
            19 => ['label' => 'PlayStation', 'icon' => 'bi-playstation'],
            20 => ['label' => 'Xbox', 'icon' => 'bi-xbox'],
            21 => ['label' => 'Nintendo', 'icon' => 'bi-nintendo-switch'],
        ];
        return $sites[$type] ?? ['label' => 'Link', 'icon' => 'bi-link-45deg'];
    }

    /**
     * Get platform icon class based on platform name
     */
    public static function getPlatformIcon(string $platformName): string
    {
        $icons = [
            // Xbox - usando joystick
            'Xbox Series X|S' => 'bi-xbox',
            'Xbox One' => 'bi-xbox',
            'Xbox 360' => 'bi-xbox',
            // PlayStation - usando controller
            'PlayStation 5' => 'bi-playstation',
            'PlayStation 4' => 'bi-playstation',
            'PlayStation 3' => 'bi-playstation',
            'PlayStation Vita' => 'bi-playstation',
            'PlayStation Portable' => 'bi-playstation',
            // Nintendo - usando joystick
            'Nintendo Switch' => 'bi-nintendo-switch',
            'Nintendo Switch 2' => 'bi-nintendo-switch',
            'Wii U' => 'bi-nintendo-switch',
            'Nintendo DS' => 'bi-nintendo-switch',
            'Nintendo DSi' => 'bi-nintendo-switch',
            'Nintendo 3DS' => 'bi-nintendo-switch',
            // PC/Windows
            'PC (Microsoft Windows)' => 'bi-windows',
            'Windows Phone' => 'bi-windows',
            // Apple
            'Mac' => 'bi-apple',
            'iOS' => 'bi-apple',
            // Mobile/Android
            'Android' => 'bi-android2',
            'Legacy Mobile Device' => 'bi-phone-fill',
            // VR/Meta
            'Meta Quest 2' => 'bi-headset-vr',
            'Meta Quest 3' => 'bi-headset-vr',
            // Other
            'Google Stadia' => 'bi-google',
            'Web browser' => 'bi-globe',
            'Linux' => 'bi-terminal',
        ];
        
        return $icons[$platformName] ?? 'bi-controller';
    }
}
