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
            <div class="custom-select-wrapper" id="platformDropdown">
                <div class="custom-select-trigger">
                    <span><i class="bi bi-grid-fill"></i> Todas</span>
                    <i class="bi bi-chevron-down"></i>
                </div>
                <div class="custom-options">
                    <div class="custom-option selected" data-value=""><i class="bi bi-grid-fill"></i> Todas</div>
                    <div class="custom-option" data-value="Mobile"><i class="bi bi-phone-fill"></i> Mobile</div>
                    <div class="custom-option" data-value="Nintendo"><i class="bi bi-nintendo-switch"></i> Nintendo</div>
                    <div class="custom-option" data-value="PC"><i class="bi bi-pc-display"></i> PC</div>
                    <div class="custom-option" data-value="PlayStation"><i class="bi bi-playstation"></i> PlayStation</div>
                    <div class="custom-option" data-value="Xbox"><i class="bi bi-xbox"></i> Xbox</div>
                </div>
                <input type="hidden" id="platformFilter" value="">
            </div>
        </div>
        
        <div class="filter-group">
            <label>Console</label>
            <div class="custom-select-wrapper" id="consoleDropdown">
                <div class="custom-select-trigger">
                    <span><i class="bi bi-controller"></i> Todos</span>
                    <i class="bi bi-chevron-down"></i>
                </div>
                <div class="custom-options custom-options-scroll">
                    <div class="custom-option selected" data-value=""><i class="bi bi-controller"></i> Todos</div>
                    <div class="custom-option" data-value="PS3"><i class="bi bi-playstation"></i> PS3</div>
                    <div class="custom-option" data-value="PS4"><i class="bi bi-playstation"></i> PS4</div>
                    <div class="custom-option" data-value="PS5"><i class="bi bi-playstation"></i> PS5</div>
                    <div class="custom-option" data-value="PSP"><i class="bi bi-playstation"></i> PSP</div>
                    <div class="custom-option" data-value="Vita"><i class="bi bi-playstation"></i> Vita</div>
                    <div class="custom-option" data-value="X360"><i class="bi bi-xbox"></i> X360</div>
                    <div class="custom-option" data-value="XONE"><i class="bi bi-xbox"></i> XONE</div>
                    <div class="custom-option" data-value="Series X|S"><i class="bi bi-xbox"></i> Series X|S</div>
                    <div class="custom-option" data-value="Switch"><i class="bi bi-nintendo-switch"></i> Switch</div>
                    <div class="custom-option" data-value="WiiU"><i class="bi bi-nintendo-switch"></i> WiiU</div>
                    <div class="custom-option" data-value="NDS"><i class="bi bi-nintendo-switch"></i> NDS</div>
                    <div class="custom-option" data-value="3DS"><i class="bi bi-nintendo-switch"></i> 3DS</div>
                    <div class="custom-option" data-value="PC"><i class="bi bi-windows"></i> PC</div>
                    <div class="custom-option" data-value="MAC"><i class="bi bi-apple"></i> MAC</div>
                    <div class="custom-option" data-value="Stadia"><i class="bi bi-google"></i> Stadia</div>
                    <div class="custom-option" data-value="iOS"><i class="bi bi-apple"></i> iOS</div>
                    <div class="custom-option" data-value="Android"><i class="bi bi-android2"></i> Android</div>
                    <div class="custom-option" data-value="Win Phone"><i class="bi bi-windows"></i> Win Phone</div>
                </div>
                <input type="hidden" id="consoleFilter" value="">
            </div>
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
    // Filter logic with Platform (brand) and Console (generation)
    const searchInput = document.getElementById('searchInput');
    const platformFilter = document.getElementById('platformFilter');
    const consoleFilter = document.getElementById('consoleFilter');
    const sections = document.querySelectorAll('.category-section');
    
    // Mapping of platform brands to their console abbreviations
    const platformMapping = {
        'Mobile': ['iOS', 'Android', 'Win Phone'],
        'Nintendo': ['Switch', 'WiiU', 'NDS', '3DS'],
        'PC': ['PC', 'MAC', 'Stadia'],
        'PlayStation': ['PS3', 'PS4', 'PS5', 'PSP', 'Vita'],
        'Xbox': ['X360', 'XONE', 'Series X|S', 'XSX']
    };
    
    function filterGames() {
        const query = searchInput.value.toLowerCase();
        const platform = platformFilter.value;
        const console = consoleFilter.value;
        
        sections.forEach(section => {
            const cards = section.querySelectorAll('.card');
            let hasVisibleCards = false;
            
            cards.forEach(card => {
                const name = card.dataset.name.toLowerCase();
                const cardPlatforms = card.dataset.platforms;
                
                const matchesSearch = name.includes(query);
                
                // Platform (brand) filter
                let matchesPlatform = true;
                if (platform !== '') {
                    const brandConsoles = platformMapping[platform] || [];
                    matchesPlatform = brandConsoles.some(c => cardPlatforms.includes(c));
                }
                
                // Console (specific) filter
                const matchesConsole = console === '' || cardPlatforms.includes(console);
                
                if (matchesSearch && matchesPlatform && matchesConsole) {
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
    consoleFilter.addEventListener('change', filterGames);
    
    // Custom dropdown logic
    const platformDropdown = document.getElementById('platformDropdown');
    const trigger = platformDropdown.querySelector('.custom-select-trigger');
    const options = platformDropdown.querySelectorAll('.custom-option');
    const triggerText = trigger.querySelector('span');
    
    trigger.addEventListener('click', (e) => {
        e.stopPropagation();
        consoleDropdown.classList.remove('open');
        platformDropdown.classList.toggle('open');
    });
    
    options.forEach(option => {
        option.addEventListener('click', () => {
            // Update selected
            options.forEach(o => o.classList.remove('selected'));
            option.classList.add('selected');
            
            // Update trigger display
            triggerText.innerHTML = option.innerHTML;
            
            // Update hidden input
            platformFilter.value = option.dataset.value;
            
            // Close dropdown
            platformDropdown.classList.remove('open');
            
            // Trigger filter
            filterGames();
        });
    });
    
    // Console dropdown logic
    const consoleDropdown = document.getElementById('consoleDropdown');
    const consoleTrigger = consoleDropdown.querySelector('.custom-select-trigger');
    const consoleOptions = consoleDropdown.querySelectorAll('.custom-option');
    const consoleTriggerText = consoleTrigger.querySelector('span');
    
    consoleTrigger.addEventListener('click', (e) => {
        e.stopPropagation();
        platformDropdown.classList.remove('open');
        consoleDropdown.classList.toggle('open');
    });
    
    consoleOptions.forEach(option => {
        option.addEventListener('click', () => {
            consoleOptions.forEach(o => o.classList.remove('selected'));
            option.classList.add('selected');
            consoleTriggerText.innerHTML = option.innerHTML;
            consoleFilter.value = option.dataset.value;
            consoleDropdown.classList.remove('open');
            filterGames();
        });
    });
    
    // Close dropdowns when clicking outside
    document.addEventListener('click', (e) => {
        if (!platformDropdown.contains(e.target)) {
            platformDropdown.classList.remove('open');
        }
        if (!consoleDropdown.contains(e.target)) {
            consoleDropdown.classList.remove('open');
        }
    });
</script>
