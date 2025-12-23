<?php
$gameId = $_GET['game_id'] ?? null;

if (!$gameId) {
    header('Location: jogos.php');
    exit;
}

$accessToken = 'l6p3tnk3677zj5qdtlz095pngs48jn';
$clientID = 'dytp463ksb6k09r6e4nqkhp6u8gt62';

// Buscar dados completos do jogo
$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => "https://api.igdb.com/v4/games",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => [
        "Client-ID: $clientID",
        "Authorization: Bearer $accessToken",
        "Accept: application/json"
    ],
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => "fields name, cover.url, summary, storyline, 
        genres.name, platforms.name, platforms.platform_logo.url,
        release_dates.date, release_dates.platform.name,
        screenshots.url, screenshots.image_id,
        videos.video_id, videos.name,
        artworks.url, artworks.image_id,
        involved_companies.company.name, involved_companies.developer, involved_companies.publisher,
        themes.name, game_modes.name,
        aggregated_rating, aggregated_rating_count,
        rating, rating_count,
        similar_games.name, similar_games.cover.url,
        websites.url, websites.category,
        age_ratings.rating, age_ratings.category;
        where id = $gameId;"
]);

$response = curl_exec($curl);
curl_close($curl);
$gameDetails = json_decode($response, true);
$game = (is_array($gameDetails) && !empty($gameDetails)) ? $gameDetails[0] : null;

// Categorias de websites
$websiteCategories = [
    1 => ['name' => 'Oficial', 'icon' => '🌐'],
    2 => ['name' => 'Wikia', 'icon' => '📖'],
    3 => ['name' => 'Wikipedia', 'icon' => '📚'],
    4 => ['name' => 'Facebook', 'icon' => '👤'],
    5 => ['name' => 'Twitter', 'icon' => '🐦'],
    6 => ['name' => 'Twitch', 'icon' => '🎮'],
    8 => ['name' => 'Instagram', 'icon' => '📷'],
    9 => ['name' => 'YouTube', 'icon' => '▶️'],
    10 => ['name' => 'iPhone', 'icon' => '📱'],
    11 => ['name' => 'iPad', 'icon' => '📱'],
    12 => ['name' => 'Android', 'icon' => '🤖'],
    13 => ['name' => 'Steam', 'icon' => '🎮'],
    14 => ['name' => 'Reddit', 'icon' => '🔴'],
    15 => ['name' => 'Itch', 'icon' => '🎮'],
    16 => ['name' => 'Epic Games', 'icon' => '🎮'],
    17 => ['name' => 'GOG', 'icon' => '🎮'],
    18 => ['name' => 'Discord', 'icon' => '💬'],
];
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $game ? htmlspecialchars($game['name']) : 'Detalhes' ?> - AC Database</title>
    <link rel="icon" href="./IMG/favicon.png" type="image/x-icon" />
    <link rel="stylesheet" href="./CSS/style.css">
    <style>
        .rating-box {
            display: flex;
            gap: 1.5em;
            margin-bottom: 1.5em;
        }
        .rating-item {
            background: rgba(0,0,0,0.1);
            padding: 1em;
            text-align: center;
            flex: 1;
            border-left: 3px solid var(--accent-red);
        }
        .rating-score {
            font-size: 2rem;
            font-weight: 700;
            color: #222;
        }
        .rating-label {
            font-size: 0.7rem;
            text-transform: uppercase;
            color: #666;
            letter-spacing: 0.1em;
        }
        .rating-count {
            font-size: 0.75rem;
            color: #888;
        }
        .media-gallery {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 0.75em;
            margin-top: 1em;
        }
        .media-gallery img {
            width: 100%;
            height: 100px;
            object-fit: cover;
            cursor: pointer;
            transition: all 0.3s;
            border: 2px solid transparent;
        }
        .media-gallery img:hover {
            border-color: var(--accent-red);
            transform: scale(1.02);
        }
        .video-embed {
            position: relative;
            padding-bottom: 56.25%;
            height: 0;
            margin-top: 1em;
        }
        .video-embed iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
        .tags-container {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5em;
            margin-top: 0.5em;
        }
        .tag {
            background: rgba(0,0,0,0.1);
            padding: 0.25em 0.75em;
            font-size: 0.75rem;
            text-transform: uppercase;
            border-left: 2px solid var(--accent-red);
        }
        .links-container {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5em;
            margin-top: 1em;
        }
        .link-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5em;
            padding: 0.5em 1em;
            background: rgba(0,0,0,0.1);
            color: #333;
            text-decoration: none;
            font-size: 0.8rem;
            transition: all 0.3s;
        }
        .link-btn:hover {
            background: var(--accent-red);
            color: #fff;
        }
        .similar-games {
            display: flex;
            gap: 1em;
            overflow-x: auto;
            padding: 0.5em 0;
        }
        .similar-game {
            flex: 0 0 120px;
            text-align: center;
        }
        .similar-game img {
            width: 100%;
            height: 160px;
            object-fit: cover;
        }
        .similar-game span {
            display: block;
            font-size: 0.75rem;
            margin-top: 0.5em;
            color: #333;
        }
        .companies-list {
            display: flex;
            flex-wrap: wrap;
            gap: 1em;
            margin-top: 0.5em;
        }
        .company-badge {
            padding: 0.5em 1em;
            background: rgba(0,0,0,0.05);
            font-size: 0.8rem;
        }
        .company-badge.developer {
            border-left: 3px solid #4CAF50;
        }
        .company-badge.publisher {
            border-left: 3px solid #2196F3;
        }
    </style>
</head>
<body>
    <div class="container clearfix">
        <!-- Menu Lateral -->
        <nav id="menu">
            <div class="title">Database</div>
            <ul class="items">
                <li><a href="index.php" class="item">Home</a></li>
                <li><a href="jogos.php" class="item active">Jogos</a></li>
                <li><a href="personagens.php" class="item">Personagens</a></li>
                <li><a href="timeline.php" class="item">Timeline</a></li>
            </ul>
        </nav>

        <!-- Conteúdo Principal -->
        <main id="content">
            <div class="title">Detalhes do Jogo</div>
            
            <?php if ($game): ?>
            <div class="detail-container">
                <img 
                    src="<?= isset($game['cover']['url']) ? 'https:' . str_replace('t_thumb', 't_cover_big_2x', $game['cover']['url']) : './IMG/default_cover.png'; ?>" 
                    alt="<?= htmlspecialchars($game['name']) ?>"
                >
                
                <div class="detail-content">
                    <h2><?= htmlspecialchars($game['name']) ?></h2>
                    
                    <!-- Ratings -->
                    <?php if (isset($game['aggregated_rating']) || isset($game['rating'])): ?>
                    <div class="rating-box">
                        <?php if (isset($game['aggregated_rating'])): ?>
                        <div class="rating-item">
                            <div class="rating-score"><?= round($game['aggregated_rating']) ?></div>
                            <div class="rating-label">Nota da Crítica</div>
                            <div class="rating-count"><?= $game['aggregated_rating_count'] ?? 0 ?> reviews</div>
                        </div>
                        <?php endif; ?>
                        <?php if (isset($game['rating'])): ?>
                        <div class="rating-item">
                            <div class="rating-score"><?= round($game['rating']) ?></div>
                            <div class="rating-label">Nota dos Usuários</div>
                            <div class="rating-count"><?= $game['rating_count'] ?? 0 ?> votos</div>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                    
                    <!-- Info Grid -->
                    <div class="detail-info">
                        <?php if (isset($game['release_dates'][0]['date'])): ?>
                        <div class="detail-info-item">
                            <strong>Lançamento</strong>
                            <span><?= date('d/m/Y', $game['release_dates'][0]['date']) ?></span>
                        </div>
                        <?php endif; ?>
                        
                        <?php if (isset($game['genres'])): ?>
                        <div class="detail-info-item">
                            <strong>Gêneros</strong>
                            <span><?= implode(', ', array_column($game['genres'], 'name')) ?></span>
                        </div>
                        <?php endif; ?>
                        
                        <?php if (isset($game['game_modes'])): ?>
                        <div class="detail-info-item">
                            <strong>Modos de Jogo</strong>
                            <span><?= implode(', ', array_column($game['game_modes'], 'name')) ?></span>
                        </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Plataformas -->
                    <?php if (isset($game['platforms'])): ?>
                    <div class="detail-section">
                        <h3>Plataformas</h3>
                        <div class="tags-container">
                            <?php foreach ($game['platforms'] as $platform): ?>
                            <span class="tag"><?= htmlspecialchars($platform['name']) ?></span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <!-- Temas -->
                    <?php if (isset($game['themes'])): ?>
                    <div class="detail-section">
                        <h3>Temas</h3>
                        <div class="tags-container">
                            <?php foreach ($game['themes'] as $theme): ?>
                            <span class="tag"><?= htmlspecialchars($theme['name']) ?></span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <!-- Desenvolvedores e Publishers -->
                    <?php if (isset($game['involved_companies'])): ?>
                    <div class="detail-section">
                        <h3>Empresas</h3>
                        <div class="companies-list">
                            <?php foreach ($game['involved_companies'] as $company): ?>
                            <?php 
                                $type = '';
                                if ($company['developer'] ?? false) $type = 'developer';
                                elseif ($company['publisher'] ?? false) $type = 'publisher';
                            ?>
                            <div class="company-badge <?= $type ?>">
                                <?= htmlspecialchars($company['company']['name'] ?? 'N/A') ?>
                                <?php if ($type === 'developer'): ?><small>(Dev)</small><?php endif; ?>
                                <?php if ($type === 'publisher'): ?><small>(Pub)</small><?php endif; ?>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <!-- Summary -->
                    <?php if (isset($game['summary'])): ?>
                    <div class="detail-section">
                        <h3>Resumo</h3>
                        <p><?= nl2br(htmlspecialchars($game['summary'])) ?></p>
                    </div>
                    <?php endif; ?>
                    
                    <!-- Storyline -->
                    <?php if (isset($game['storyline'])): ?>
                    <div class="detail-section">
                        <h3>História</h3>
                        <p><?= nl2br(htmlspecialchars($game['storyline'])) ?></p>
                    </div>
                    <?php endif; ?>
                    
                    <!-- Trailer do YouTube -->
                    <?php if (isset($game['videos']) && count($game['videos']) > 0): ?>
                    <div class="detail-section">
                        <h3>Trailer</h3>
                        <div class="video-embed">
                            <iframe 
                                src="https://www.youtube.com/embed/<?= htmlspecialchars($game['videos'][0]['video_id']) ?>" 
                                frameborder="0" 
                                allowfullscreen
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            ></iframe>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <!-- Screenshots -->
                    <?php if (isset($game['screenshots']) && count($game['screenshots']) > 0): ?>
                    <div class="detail-section">
                        <h3>Screenshots</h3>
                        <div class="media-gallery">
                            <?php foreach ($game['screenshots'] as $screenshot): ?>
                            <img 
                                src="https:<?= str_replace('t_thumb', 't_screenshot_med', $screenshot['url']) ?>" 
                                alt="Screenshot"
                                onclick="window.open('https:<?= str_replace('t_thumb', 't_screenshot_huge', $screenshot['url']) ?>', '_blank')"
                                loading="lazy"
                            >
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <!-- Artworks -->
                    <?php if (isset($game['artworks']) && count($game['artworks']) > 0): ?>
                    <div class="detail-section">
                        <h3>Artes Conceituais</h3>
                        <div class="media-gallery">
                            <?php foreach ($game['artworks'] as $artwork): ?>
                            <img 
                                src="https:<?= str_replace('t_thumb', 't_screenshot_med', $artwork['url']) ?>" 
                                alt="Artwork"
                                onclick="window.open('https:<?= str_replace('t_thumb', 't_1080p', $artwork['url']) ?>', '_blank')"
                                loading="lazy"
                            >
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <!-- Links Externos -->
                    <?php if (isset($game['websites']) && count($game['websites']) > 0): ?>
                    <div class="detail-section">
                        <h3>Links</h3>
                        <div class="links-container">
                            <?php foreach ($game['websites'] as $website): 
                                $catId = $website['category'] ?? 0;
                                $cat = $websiteCategories[$catId] ?? ['name' => 'Link', 'icon' => '🔗'];
                            ?>
                            <a href="<?= htmlspecialchars($website['url']) ?>" class="link-btn" target="_blank" rel="noopener">
                                <?= $cat['icon'] ?> <?= $cat['name'] ?>
                            </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <!-- Jogos Similares -->
                    <?php if (isset($game['similar_games']) && count($game['similar_games']) > 0): ?>
                    <div class="detail-section">
                        <h3>Jogos Similares</h3>
                        <div class="similar-games">
                            <?php foreach (array_slice($game['similar_games'], 0, 6) as $similar): ?>
                            <div class="similar-game">
                                <?php if (isset($similar['cover']['url'])): ?>
                                <img src="https:<?= str_replace('t_thumb', 't_cover_small', $similar['cover']['url']) ?>" alt="<?= htmlspecialchars($similar['name']) ?>">
                                <?php endif; ?>
                                <span><?= htmlspecialchars($similar['name']) ?></span>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <a href="jogos.php" class="back-btn">← Voltar para Jogos</a>
                </div>
            </div>
            <?php else: ?>
            <div class="description">
                <p><strong>Jogo não encontrado.</strong></p>
                <p><a href="jogos.php">Voltar para a lista de jogos</a></p>
            </div>
            <?php endif; ?>
        </main>
    </div>
</body>
</html>
