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
    
    // Requisição à API com campos extras incluindo platforms.name para filtro
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
        CURLOPT_POSTFIELDS => "fields name, cover.url, summary, first_release_date, aggregated_rating, rating, platforms.abbreviation, platforms.name, platforms.platform_family, themes.name; where id = ($idsString); limit 500;"
    ]);
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    $allGames = json_decode($response, true);
    
    // Indexar jogos por ID e coletar plataformas únicas
    $gamesById = [];
    $allPlatforms = [];
    $platformFamilies = [
        'playstation' => ['PS1', 'PS2', 'PS3', 'PS4', 'PS5', 'PSP', 'PSV', 'Vita'],
        'xbox' => ['X360', 'XONE', 'XSX', 'Xbox'],
        'nintendo' => ['Switch', 'WiiU', 'Wii', '3DS', 'DS', 'NDS'],
        'pc' => ['PC', 'Mac', 'Linux'],
        'mobile' => ['iOS', 'Android', 'WinPhone']
    ];
    
    if (is_array($allGames) && !isset($allGames['message'])) {
        foreach ($allGames as $game) {
            $gamesById[$game['id']] = $game;
            if (isset($game['platforms'])) {
                foreach ($game['platforms'] as $platform) {
                    $abbr = $platform['abbreviation'] ?? '';
                    $name = $platform['name'] ?? '';
                    if ($abbr && !in_array($abbr, $allPlatforms)) {
                        $allPlatforms[] = $abbr;
                    }
                }
            }
        }
    }
    sort($allPlatforms);
    
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="./CSS/style.css">
    <style>
        /* Barra de Busca e Filtros */
        .search-filters-container {
            background: var(--title-bg);
            padding: 1.5em;
            margin-bottom: 2em;
            border-left: 4px solid var(--accent-red);
        }
        .search-box {
            display: flex;
            gap: 0.5em;
            margin-bottom: 1em;
        }
        .search-input {
            flex: 1;
            padding: 0.75em 1em;
            border: none;
            background: rgba(255,255,255,0.9);
            font-size: 1rem;
            color: #333;
        }
        .search-input:focus {
            outline: 2px solid var(--accent-red);
        }
        .search-btn {
            padding: 0.75em 1.5em;
            background: var(--accent-red);
            color: #fff;
            border: none;
            cursor: pointer;
            font-weight: 600;
            transition: background 0.3s;
        }
        .search-btn:hover {
            background: #8a0000;
        }
        
        .filters-row {
            display: flex;
            flex-wrap: wrap;
            gap: 1em;
            align-items: center;
        }
        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 0.25em;
        }
        .filter-group label {
            font-size: 0.75rem;
            text-transform: uppercase;
            color: #666;
            font-weight: 600;
        }
        .filter-select {
            padding: 0.5em 1em;
            border: none;
            background: rgba(255,255,255,0.9);
            font-size: 0.9rem;
            min-width: 180px;
            cursor: pointer;
        }
        .filter-select:focus {
            outline: 2px solid var(--accent-red);
        }
        .clear-filters-btn {
            padding: 0.5em 1em;
            background: transparent;
            border: 1px solid #666;
            color: #666;
            cursor: pointer;
            font-size: 0.85rem;
            transition: all 0.3s;
            margin-top: auto;
        }
        .clear-filters-btn:hover {
            background: #666;
            color: #fff;
        }
        
        .results-info {
            padding: 0.5em 0;
            font-size: 0.85rem;
            color: #666;
        }
        .results-info strong {
            color: var(--accent-red);
        }
        
        .no-results {
            text-align: center;
            padding: 3em;
            color: #666;
        }
        .no-results i {
            font-size: 4rem;
            display: block;
            margin-bottom: 0.5em;
            opacity: 0.3;
        }

        /* Estilos existentes */
        .category-section {
            margin-bottom: 3em;
        }
        .category-section.hidden {
            display: none;
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
        .visible-count {
            background: #666;
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
        .platform-badge.highlight {
            background: var(--accent-red);
            color: #fff;
        }
        .card.hidden {
            display: none;
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
                <li><a href="livros.php" class="item">Livros & Mídia</a></li>
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

            <!-- Barra de Busca e Filtros -->
            <div class="search-filters-container">
                <div class="search-box">
                    <input type="text" id="searchInput" class="search-input" placeholder="Buscar jogos por nome..." autocomplete="off">
                    <button class="search-btn" onclick="applyFilters()"><i class="bi bi-search"></i> Buscar</button>
                </div>
                
                <div class="filters-row">
                    <div class="filter-group">
                        <label for="familyFilter"><i class="bi bi-controller"></i> Plataforma</label>
                        <select id="familyFilter" class="filter-select" onchange="applyFilters()">
                            <option value="">Todas as Plataformas</option>
                            <option value="playstation">PlayStation</option>
                            <option value="xbox">Xbox</option>
                            <option value="nintendo">Nintendo</option>
                            <option value="pc">PC / Mac / Linux</option>
                            <option value="mobile">Mobile</option>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label for="deviceFilter"><i class="bi bi-display"></i> Dispositivo</label>
                        <select id="deviceFilter" class="filter-select" onchange="applyFilters()">
                            <option value="">Todos os Dispositivos</option>
                            <?php foreach ($allPlatforms as $platform): ?>
                            <option value="<?= htmlspecialchars($platform) ?>"><?= htmlspecialchars($platform) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <button class="clear-filters-btn" onclick="clearFilters()">
                        <i class="bi bi-x-circle"></i> Limpar Filtros
                    </button>
                </div>
                
                <div class="results-info" id="resultsInfo"></div>
            </div>

            <?php if (empty($gamesById)): ?>
                <div class="description">
                    <p><strong>Erro ao carregar jogos.</strong> O token pode ter expirado.</p>
                    <p><a href="get_token.php">Gerar novo token</a></p>
                </div>
            <?php else: ?>
                <div id="noResults" class="no-results" style="display: none;">
                    <i class="bi bi-search"></i>
                    <h3>Nenhum jogo encontrado</h3>
                    <p>Tente ajustar seus filtros ou termo de busca.</p>
                </div>

                <?php foreach ($categorias as $key => $categoria): ?>
                    <section class="category-section" id="<?= $key ?>" data-category="<?= $key ?>">
                        <div class="category-header">
                            <h2>
                                <?= htmlspecialchars($categoria['titulo']) ?>
                                <span class="game-count total-count"><?= count($categoria['ids']) ?> jogos</span>
                                <span class="game-count visible-count" style="display: none;"></span>
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
                                
                                // Preparar dados de plataforma para filtro JS
                                $platformAbbrs = [];
                                if (isset($game['platforms'])) {
                                    foreach ($game['platforms'] as $p) {
                                        if (isset($p['abbreviation'])) {
                                            $platformAbbrs[] = $p['abbreviation'];
                                        }
                                    }
                                }
                            ?>
                            <div class="card" 
                                 data-name="<?= htmlspecialchars(strtolower($game['name'] ?? '')) ?>"
                                 data-platforms="<?= htmlspecialchars(implode(',', $platformAbbrs)) ?>">
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
                                        <span class="platform-badge" data-abbr="<?= htmlspecialchars($platform['abbreviation'] ?? '') ?>"><?= htmlspecialchars($platform['abbreviation'] ?? $platform['name'] ?? '?') ?></span>
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
        // Mapeamento de famílias de plataforma
        const platformFamilies = {
            playstation: ['PS1', 'PS2', 'PS3', 'PS4', 'PS5', 'PSP', 'PSV', 'Vita', 'PS Vita'],
            xbox: ['X360', 'XONE', 'XSX', 'Xbox', 'Xbox One', 'Series X'],
            nintendo: ['Switch', 'WiiU', 'Wii', '3DS', 'DS', 'NDS', 'NSW'],
            pc: ['PC', 'Mac', 'Linux', 'Windows'],
            mobile: ['iOS', 'Android', 'WinPhone', 'Mobile']
        };
        
        const searchInput = document.getElementById('searchInput');
        const familyFilter = document.getElementById('familyFilter');
        const deviceFilter = document.getElementById('deviceFilter');
        const resultsInfo = document.getElementById('resultsInfo');
        const noResults = document.getElementById('noResults');
        
        // Busca em tempo real ao digitar
        searchInput.addEventListener('input', debounce(applyFilters, 300));
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                applyFilters();
            }
        });
        
        // Debounce para evitar muitas chamadas
        function debounce(func, wait) {
            let timeout;
            return function(...args) {
                clearTimeout(timeout);
                timeout = setTimeout(() => func.apply(this, args), wait);
            };
        }
        
        function applyFilters() {
            const searchTerm = searchInput.value.toLowerCase().trim();
            const selectedFamily = familyFilter.value;
            const selectedDevice = deviceFilter.value;
            
            const allCards = document.querySelectorAll('.card[data-name]');
            let totalVisible = 0;
            let sectionVisibility = {};
            
            allCards.forEach(card => {
                const name = card.dataset.name || '';
                const platforms = (card.dataset.platforms || '').split(',');
                
                let matchesSearch = !searchTerm || name.includes(searchTerm);
                let matchesFamily = !selectedFamily;
                let matchesDevice = !selectedDevice || platforms.includes(selectedDevice);
                
                // Verificar família de plataforma
                if (selectedFamily && platformFamilies[selectedFamily]) {
                    matchesFamily = platforms.some(p => 
                        platformFamilies[selectedFamily].some(f => 
                            p.toLowerCase().includes(f.toLowerCase()) || f.toLowerCase().includes(p.toLowerCase())
                        )
                    );
                }
                
                const isVisible = matchesSearch && matchesFamily && matchesDevice;
                card.classList.toggle('hidden', !isVisible);
                
                if (isVisible) {
                    totalVisible++;
                    // Contar para a seção
                    const section = card.closest('.category-section');
                    if (section) {
                        const catId = section.dataset.category;
                        sectionVisibility[catId] = (sectionVisibility[catId] || 0) + 1;
                    }
                }
                
                // Destacar dispositivo selecionado
                if (selectedDevice) {
                    card.querySelectorAll('.platform-badge').forEach(badge => {
                        badge.classList.toggle('highlight', badge.dataset.abbr === selectedDevice);
                    });
                } else {
                    card.querySelectorAll('.platform-badge').forEach(badge => {
                        badge.classList.remove('highlight');
                    });
                }
            });
            
            // Atualizar visibilidade das seções
            document.querySelectorAll('.category-section').forEach(section => {
                const catId = section.dataset.category;
                const visibleInSection = sectionVisibility[catId] || 0;
                const totalCount = section.querySelector('.total-count');
                const visibleCount = section.querySelector('.visible-count');
                
                if (searchTerm || selectedFamily || selectedDevice) {
                    section.classList.toggle('hidden', visibleInSection === 0);
                    if (visibleCount && totalCount) {
                        visibleCount.textContent = `${visibleInSection} visíveis`;
                        visibleCount.style.display = 'inline-block';
                    }
                } else {
                    section.classList.remove('hidden');
                    if (visibleCount) {
                        visibleCount.style.display = 'none';
                    }
                }
            });
            
            // Mostrar/esconder mensagem de sem resultados
            noResults.style.display = totalVisible === 0 ? 'block' : 'none';
            
            // Atualizar info de resultados
            const totalCards = allCards.length;
            if (searchTerm || selectedFamily || selectedDevice) {
                let filterText = [];
                if (searchTerm) filterText.push(`"${searchTerm}"`);
                if (selectedFamily) filterText.push(familyFilter.options[familyFilter.selectedIndex].text);
                if (selectedDevice) filterText.push(selectedDevice);
                
                resultsInfo.innerHTML = `<strong>${totalVisible}</strong> de ${totalCards} jogos encontrados ${filterText.length ? '(' + filterText.join(', ') + ')' : ''}`;
            } else {
                resultsInfo.innerHTML = '';
            }
        }
        
        function clearFilters() {
            searchInput.value = '';
            familyFilter.value = '';
            deviceFilter.value = '';
            applyFilters();
        }
        
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
    <script src="./JS/main.js"></script>
</body>
</html>