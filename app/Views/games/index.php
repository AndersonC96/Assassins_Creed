<div class="title">Jogos da Saga</div>
            
<div class="description">
    <p>Explore todos os títulos da franquia <em>Assassin's Creed</em>. As notas exibidas são da <strong>crítica especializada</strong> (Metacritic/OpenCritic).</p>
</div>

<!-- Barra de Busca e Filtros -->
<div class="search-filters-container">
    <input type="text" class="search-input" id="searchInput" placeholder="Buscar jogo..." style="width: 100%; margin-bottom: 1em;">
    
    <div class="filters-row">
        <div class="filter-group">
            <label>Plataforma</label>
            <select class="filter-select" id="platformFilter">
                <option value="">Todas</option>
                <?php 
                $platforms = ['PS3', 'PS4', 'PS5', 'X360', 'XONE', 'XSX', 'PC', 'Switch', 'WiiU'];
                foreach ($platforms as $p): 
                ?>
                <option value="<?= $p ?>"><?= $p ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div class="filter-group">
            <label>Ordenar por</label>
            <select class="filter-select" id="sortFilter">
                <option value="release_desc">Lançamento (Novo -> Antigo)</option>
                <option value="release_asc">Lançamento (Antigo -> Novo)</option>
                <option value="rating_desc">Melhor Avaliados</option>
                <option value="rating_by_user">Nota dos Usuários</option>
            </select>
        </div>
    </div>
</div>

<div id="gamesContainer">
    <?php foreach ($categories as $key => $cat): ?>
    <div class="category-section" id="<?= $key ?>" data-category="<?= $key ?>">
        <div class="category-header">
            <h2><?= htmlspecialchars($cat['titulo']) ?></h2>
            <p style="margin: 0; font-size: 0.8rem; opacity: 0.7;"><?= htmlspecialchars($cat['desc']) ?></p>
        </div>
        
        <div class="games-grid">
            <?php foreach ($cat['games'] as $game): 
                $ratingColor = \App\Models\Game::getRatingColor($game['aggregated_rating'] ?? null);
                $genres = '';
                if (isset($game['genres'])) {
                    $genres = implode(', ', array_map(function($g) { return $g['name']; }, $game['genres']));
                }
            ?>
            <a href="<?= $baseUrl ?>/games/show/<?= $game['id'] ?>" class="card" 
               data-name="<?= htmlspecialchars($game['name']) ?>"
               data-date="<?= $game['first_release_date'] ?? 0 ?>"
               data-rating="<?= $game['aggregated_rating'] ?? 0 ?>"
               data-platforms="<?= isset($game['platforms']) ? implode(',', array_column($game['platforms'], 'abbreviation')) : '' ?>">
               
                <div class="card-image-container">
                    <img src="<?= isset($game['cover']['url']) ? 'https:' . str_replace('t_thumb', 't_cover_big', $game['cover']['url']) : $baseUrl . '/IMG/default_cover.png' ?>" 
                         alt="<?= htmlspecialchars($game['name']) ?>">
                    
                    <?php if (isset($game['aggregated_rating'])): ?>
                    <div class="card-rating" style="background: <?= $ratingColor ?>">
                        <?= round($game['aggregated_rating']) ?>
                    </div>
                    <?php endif; ?>
                </div>
                
                <div class="card-content">
                    <h3><?= htmlspecialchars($game['name']) ?></h3>
                    <p>
                        <?= isset($game['first_release_date']) ? date('Y', $game['first_release_date']) : 'TBA' ?>
                        <!-- &bull; <?= htmlspecialchars($genres) ?> -->
                    </p>
                    
                    <?php if (isset($game['platforms'])): ?>
                    <div class="card-platforms">
                        <?php foreach (array_slice($game['platforms'], 0, 4) as $platform): ?>
                        <span class="platform-badge"><?= $platform['abbreviation'] ?? $platform['name'] ?></span>
                        <?php endforeach; ?>
                        <?php if (count($game['platforms']) > 4): ?>
                        <span class="platform-badge">+<?= count($game['platforms']) - 4 ?></span>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<script>
    // Simple filter logic for view
    const searchInput = document.getElementById('searchInput');
    const platformFilter = document.getElementById('platformFilter');
    const sections = document.querySelectorAll('.category-section');
    
    function filterGames() {
        const query = searchInput.value.toLowerCase();
        const platform = platformFilter.value;
        
        sections.forEach(section => {
            const cards = section.querySelectorAll('.card');
            let hasVisibleCards = false;
            
            cards.forEach(card => {
                const name = card.dataset.name.toLowerCase();
                const cardPlatforms = card.dataset.platforms;
                
                const matchesSearch = name.includes(query);
                const matchesPlatform = platform === '' || cardPlatforms.includes(platform);
                
                if (matchesSearch && matchesPlatform) {
                    card.style.display = '';
                    hasVisibleCards = true;
                } else {
                    card.style.display = 'none';
                }
            });
            
            section.style.display = hasVisibleCards ? '' : 'none';
        });
    }
    
    searchInput.addEventListener('input', filterGames);
    platformFilter.addEventListener('change', filterGames);
</script>
