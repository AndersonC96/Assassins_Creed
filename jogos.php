<?php
    $accessToken = 'l6p3tnk3677zj5qdtlz095pngs48jn';
    $clientID = 'dytp463ksb6k09r6e4nqkhp6u8gt62';
    
    // Categorias de jogos
    $categorias = [
        'principal' => [
            'titulo' => 'Série Principal',
            'desc' => 'Os títulos principais da saga Assassin\'s Creed',
            'ids' => [128, 127, 113, 537, 1266, 1970, 7570, 5606, 8263, 28540, 103054, 133004, 215060, 300976]
        ],
        'spinoffs' => [
            'titulo' => 'Spin-offs',
            'desc' => 'Jogos derivados e expansões do universo AC',
            'ids' => [68526, 21349, 68527, 10661, 18865, 68528, 68529, 77209, 77265, 3195, 68530, 20077, 3775, 64759, 8223, 14902, 14903, 251353, 41030, 251568, 135506, 133962, 152231, 26917, 64765]
        ],
        'remastered' => [
            'titulo' => 'Remastered',
            'desc' => 'Versões remasterizadas dos clássicos',
            'ids' => [20864, 81205, 109532, 109533]
        ],
        'colecoes' => [
            'titulo' => 'Coletâneas e Relançamentos',
            'desc' => 'Compilações da saga',
            'ids' => [22754, 43015, 22815, 23954, 122236]
        ],
        'cancelados' => [
            'titulo' => 'Cancelados e descontinuados',
            'desc' => 'Jogos cancelados e descontinuados',
            'ids' => [64737, 61278, 17028]
        ],
        'embreve' => [
            'titulo' => 'Em Breve',
            'desc' => 'Próximos lançamentos da franquia',
            'ids' => [216319, 216321]
        ]
    ];
    
    // Todos os IDs para uma única requisição
    $allIds = [];
    foreach ($categorias as $cat) {
        $allIds = array_merge($allIds, $cat['ids']);
    }
    $allIds = array_unique($allIds);
    $idsString = implode(',', $allIds);
    
    // Requisição à API com campos extras
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
        CURLOPT_POSTFIELDS => "fields name, cover.url, summary, first_release_date, aggregated_rating, rating, platforms.abbreviation, themes.name; where id = ($idsString); limit 500;"
    ]);
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    $allGames = json_decode($response, true);
    
    // Indexar jogos por ID
    $gamesById = [];
    if (is_array($allGames) && !isset($allGames['message'])) {
        foreach ($allGames as $game) {
            $gamesById[$game['id']] = $game;
        }
    }
    
    // Função para ordenar por data
    function sortByDate($a, $b) {
        $dateA = $a['first_release_date'] ?? PHP_INT_MAX;
        $dateB = $b['first_release_date'] ?? PHP_INT_MAX;
        return $dateA - $dateB;
    }
    
    // Função para cor da nota
    function getRatingColor($rating) {
        if ($rating >= 75) return '#4CAF50';
        if ($rating >= 50) return '#FFC107';
        return '#f44336';
    }
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jogos - Assassin's Creed Database</title>
    <meta name="description" content="Lista completa de todos os jogos da franquia Assassin's Creed organizados por categoria.">
    <link rel="icon" href="./IMG/favicon.png" type="image/x-icon" />
    <link rel="stylesheet" href="./CSS/style.css">
    <style>
        .category-section {
            margin-bottom: 3em;
        }
        .category-header {
            background: var(--title-bg);
            padding: 1em;
            margin-bottom: 1em;
            border-left: 4px solid var(--accent-red);
        }
        .category-header h2 {
            color: var(--title-color);
            font-size: 1.25rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin: 0;
        }
        .category-header p {
            color: #999;
            font-size: 0.85rem;
            margin: 0.5em 0 0 0;
        }
        .game-count {
            display: inline-block;
            background: var(--accent-red);
            color: #fff;
            padding: 0.25em 0.5em;
            font-size: 0.7rem;
            margin-left: 0.5em;
            vertical-align: middle;
        }
        .card-rating {
            position: absolute;
            top: 10px;
            right: 10px;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.85rem;
            color: #fff;
            box-shadow: 0 2px 8px rgba(0,0,0,0.3);
        }
        .card-image-container {
            position: relative;
        }
        .card-platforms {
            display: flex;
            flex-wrap: wrap;
            gap: 0.25em;
            margin-top: 0.5em;
        }
        .platform-badge {
            background: rgba(0,0,0,0.1);
            padding: 0.15em 0.4em;
            font-size: 0.65rem;
            text-transform: uppercase;
        }
        .card-themes {
            display: flex;
            gap: 0.25em;
            margin-top: 0.5em;
            flex-wrap: wrap;
        }
        .theme-tag {
            background: var(--accent-red);
            color: #fff;
            padding: 0.1em 0.4em;
            font-size: 0.6rem;
            text-transform: uppercase;
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
            
            <!-- Sub-navegação de categorias -->
            <div class="title" style="margin-top: 2em; font-size: 100%;">Categorias</div>
            <ul class="items">
                <li><a href="#principal" class="item">Série Principal</a></li>
                <li><a href="#spinoffs" class="item">Spin-offs</a></li>
                <li><a href="#remastered" class="item">Remastered</a></li>
                <li><a href="#colecoes" class="item">Coletâneas e Relançamentos</a></li>
                <li><a href="#cancelados" class="item">Cancelados e Descontinuados</a></li>
                <li><a href="#embreve" class="item">Em Breve</a></li>
            </ul>
        </nav>

        <!-- Conteúdo Principal -->
        <main id="content">
            <div class="title">Jogos da Saga</div>
            
            <div class="description">
                <p>Explore todos os títulos da franquia <em>Assassin's Creed</em>. As notas exibidas são da <strong>crítica especializada</strong> (Metacritic/OpenCritic).</p>
            </div>

            <?php if (empty($gamesById)): ?>
                <div class="description">
                    <p><strong>Erro ao carregar jogos.</strong> O token pode ter expirado.</p>
                    <p><a href="get_token.php">Gerar novo token</a></p>
                </div>
            <?php else: ?>
                <?php foreach ($categorias as $key => $categoria): ?>
                    <section class="category-section" id="<?= $key ?>">
                        <div class="category-header">
                            <h2>
                                <?= htmlspecialchars($categoria['titulo']) ?>
                                <span class="game-count"><?= count($categoria['ids']) ?> jogos</span>
                            </h2>
                            <p><?= htmlspecialchars($categoria['desc']) ?></p>
                        </div>
                        
                        <div class="cards-grid">
                            <?php 
                            // Pegar jogos desta categoria
                            $categoryGames = [];
                            foreach ($categoria['ids'] as $id) {
                                if (isset($gamesById[$id])) {
                                    $categoryGames[] = $gamesById[$id];
                                }
                            }
                            // Ordenar por data
                            usort($categoryGames, 'sortByDate');
                            
                            foreach ($categoryGames as $game): 
                                $rating = $game['aggregated_rating'] ?? $game['rating'] ?? null;
                                $ratingColor = $rating ? getRatingColor($rating) : '#666';
                            ?>
                            <div class="card">
                                <div class="card-image-container">
                                    <img 
                                        src="<?= isset($game['cover']['url']) ? 'https:' . str_replace('t_thumb', 't_cover_big', $game['cover']['url']) : './IMG/default_cover.png'; ?>" 
                                        alt="<?= htmlspecialchars($game['name'] ?? 'Game Cover') ?>"
                                        loading="lazy"
                                    >
                                    <?php if ($rating): ?>
                                    <div class="card-rating" style="background: <?= $ratingColor ?>;">
                                        <?= round($rating) ?>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="card-content">
                                    <div class="card-title"><?= htmlspecialchars($game['name'] ?? 'Nome não disponível') ?></div>
                                    <?php if (isset($game['first_release_date'])): ?>
                                        <div class="card-year"><?= date('Y', $game['first_release_date']) ?></div>
                                    <?php else: ?>
                                        <div class="card-year">TBA</div>
                                    <?php endif; ?>
                                    
                                    <?php if (isset($game['platforms'])): ?>
                                    <div class="card-platforms">
                                        <?php foreach (array_slice($game['platforms'], 0, 4) as $platform): ?>
                                        <span class="platform-badge"><?= htmlspecialchars($platform['abbreviation'] ?? $platform['name'] ?? '?') ?></span>
                                        <?php endforeach; ?>
                                        <?php if (count($game['platforms']) > 4): ?>
                                        <span class="platform-badge">+<?= count($game['platforms']) - 4 ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <?php endif; ?>
                                    
                                    <a href="game_details.php?game_id=<?= $game['id']; ?>" class="card-btn">Ver Detalhes</a>
                                </div>
                            </div>
                            <?php endforeach; ?>
                            
                            <?php if (empty($categoryGames)): ?>
                                <div class="description" style="grid-column: 1 / -1;">
                                    <p>Nenhum jogo encontrado nesta categoria.</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </section>
                <?php endforeach; ?>
            <?php endif; ?>
        </main>
    </div>
    
    <script>
        // Smooth scroll para âncoras
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });
    </script>
</body>
</html>