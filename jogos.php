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
            'ids' => [68526, 21349, 68527, 10661, 18865, 68528, 68529, 64737, 77209, 77265, 3195, 68530, 20077, 3775, 64759, 8223, 14902, 14903, 17028, 251353, 41030, 251568, 135506, 133962, 152231, 26917, 64765]
        ],
        'remastered' => [
            'titulo' => 'Remastered',
            'desc' => 'Versões remasterizadas dos clássicos',
            'ids' => [20864, 81205, 109532]
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
    
    // Requisição à API
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
        CURLOPT_POSTFIELDS => "fields name, cover.url, summary, first_release_date; where id = ($idsString); limit 500;"
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
                <li><a href="#embreve" class="item">Em Breve</a></li>
            </ul>
        </nav>

        <!-- Conteúdo Principal -->
        <main id="content">
            <div class="title">Jogos da Saga</div>
            
            <div class="description">
                <p>Explore todos os títulos da franquia <em>Assassin's Creed</em> organizados por categoria.</p>
                <p><strong>Clique</strong> em uma categoria no menu lateral para navegar rapidamente.</p>
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
                            ?>
                            <div class="card">
                                <img 
                                    src="<?= isset($game['cover']['url']) ? 'https:' . str_replace('t_thumb', 't_cover_big', $game['cover']['url']) : './IMG/default_cover.png'; ?>" 
                                    alt="<?= htmlspecialchars($game['name'] ?? 'Game Cover') ?>"
                                    loading="lazy"
                                >
                                <div class="card-content">
                                    <div class="card-title"><?= htmlspecialchars($game['name'] ?? 'Nome não disponível') ?></div>
                                    <?php if (isset($game['first_release_date'])): ?>
                                        <div class="card-year"><?= date('Y', $game['first_release_date']) ?></div>
                                    <?php else: ?>
                                        <div class="card-year">TBA</div>
                                    <?php endif; ?>
                                    <div class="card-desc"><?= isset($game['summary']) ? htmlspecialchars(mb_strimwidth($game['summary'], 0, 100, '...')) : 'Sem descrição'; ?></div>
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