<div class="title">Livros & Mídia</div>

<div class="description">
    <p>Explore o vasto universo expandido de <strong>Assassin's Creed</strong> através de romances, histórias em quadrinhos, filmes e materiais de referência.</p>
</div>

<?php
// Calculate totals
$totalRomances = count($romances);
$totalComics = count($comics);
$totalFilmes = count($filmes);
$totalOutros = count($outros);
$totalMidia = $totalRomances + $totalComics + $totalFilmes + $totalOutros;

// Type configurations
$typeConfig = [
    'romance' => ['icon' => 'book-fill', 'color' => '#1a5276', 'label' => 'Romance'],
    'comic' => ['icon' => 'journal-richtext', 'color' => '#7d3c98', 'label' => 'Comic'],
    'filme' => ['icon' => 'film', 'color' => '#b9770e', 'label' => 'Filme'],
    'curta' => ['icon' => 'camera-video', 'color' => '#922b21', 'label' => 'Curta'],
    'animação' => ['icon' => 'play-circle', 'color' => '#1e8449', 'label' => 'Animação'],
    'série' => ['icon' => 'tv', 'color' => '#8B0000', 'label' => 'Série'],
    'artbook' => ['icon' => 'palette', 'color' => '#922b21', 'label' => 'Artbook'],
    'enciclopedia' => ['icon' => 'book', 'color' => '#1a5276', 'label' => 'Enciclopédia'],
    'guia' => ['icon' => 'journal-text', 'color' => '#1e8449', 'label' => 'Guia'],
    'atlas' => ['icon' => 'map', 'color' => '#b9770e', 'label' => 'Atlas'],
];
?>

<!-- Barra de Busca e Filtros -->
<div class="search-filters-container">
    <input type="text" class="search-input" id="searchInput" placeholder="Buscar por título, autor ou descrição...">
    
    <div class="filters-row">
        <div class="filter-group">
            <label>Categoria</label>
            <div class="custom-select-wrapper" id="categoryDropdown">
                <div class="custom-select-trigger">
                    <span><i class="bi bi-grid-fill"></i> Todas (<?= $totalMidia ?>)</span>
                    <i class="bi bi-chevron-down"></i>
                </div>
                <div class="custom-options">
                    <div class="custom-option selected" data-value="all">
                        <i class="bi bi-grid-fill"></i> Todas (<?= $totalMidia ?>)
                    </div>
                    <div class="custom-option" data-value="romances">
                        <i class="bi bi-book-fill"></i> Romances (<?= $totalRomances ?>)
                    </div>
                    <div class="custom-option" data-value="comics">
                        <i class="bi bi-journal-richtext"></i> Comics (<?= $totalComics ?>)
                    </div>
                    <div class="custom-option" data-value="filmes">
                        <i class="bi bi-film"></i> Filmes & Séries (<?= $totalFilmes ?>)
                    </div>
                    <div class="custom-option" data-value="outros">
                        <i class="bi bi-collection"></i> Artbooks & Outros (<?= $totalOutros ?>)
                    </div>
                </div>
                <input type="hidden" id="categoryFilter" value="all">
            </div>
        </div>
        
        <div class="filter-group">
            <label>Ordenar por</label>
            <div class="custom-select-wrapper" id="sortDropdown">
                <div class="custom-select-trigger">
                    <span><i class="bi bi-sort-down"></i> Mais Recentes</span>
                    <i class="bi bi-chevron-down"></i>
                </div>
                <div class="custom-options">
                    <div class="custom-option selected" data-value="newest">
                        <i class="bi bi-sort-down"></i> Mais Recentes
                    </div>
                    <div class="custom-option" data-value="oldest">
                        <i class="bi bi-sort-up"></i> Mais Antigos
                    </div>
                    <div class="custom-option" data-value="title">
                        <i class="bi bi-sort-alpha-down"></i> Título (A-Z)
                    </div>
                </div>
                <input type="hidden" id="sortFilter" value="newest">
            </div>
        </div>
    </div>
</div>

<!-- Stats Cards Premium -->
<div class="media-stats-grid">
    <div class="media-stat-card" data-category="romances">
        <div class="stat-icon" style="background: linear-gradient(135deg, #1a5276, #2471a3);">
            <i class="bi bi-book-fill"></i>
        </div>
        <div class="stat-info">
            <span class="stat-number"><?= $totalRomances ?></span>
            <span class="stat-label">Romances</span>
        </div>
    </div>
    <div class="media-stat-card" data-category="comics">
        <div class="stat-icon" style="background: linear-gradient(135deg, #7d3c98, #9b59b6);">
            <i class="bi bi-journal-richtext"></i>
        </div>
        <div class="stat-info">
            <span class="stat-number"><?= $totalComics ?></span>
            <span class="stat-label">Comics</span>
        </div>
    </div>
    <div class="media-stat-card" data-category="filmes">
        <div class="stat-icon" style="background: linear-gradient(135deg, #b9770e, #d4ac0d);">
            <i class="bi bi-film"></i>
        </div>
        <div class="stat-info">
            <span class="stat-number"><?= $totalFilmes ?></span>
            <span class="stat-label">Filmes & Séries</span>
        </div>
    </div>
    <div class="media-stat-card" data-category="outros">
        <div class="stat-icon" style="background: linear-gradient(135deg, #922b21, #c0392b);">
            <i class="bi bi-collection"></i>
        </div>
        <div class="stat-info">
            <span class="stat-number"><?= $totalOutros ?></span>
            <span class="stat-label">Artbooks</span>
        </div>
    </div>
</div>

<!-- Media Container -->
<div id="mediaContainer">

    <!-- Romances Section -->
    <section class="media-section" id="romances" data-category="romances">
        <div class="category-header">
            <h2><i class="bi bi-book-fill"></i> Romances</h2>
            <p style="margin: 0; font-size: 0.8rem; opacity: 0.7;">Novelizações oficiais da série</p>
        </div>
        
        <div class="media-cards-grid">
            <?php foreach ($romances as $item): 
                $config = $typeConfig[$item['tipo']] ?? $typeConfig['romance'];
            ?>
            <div class="media-card-styled" 
                 data-searchable="<?= strtolower(($item['titulo'] ?? '') . ' ' . ($item['autor'] ?? '') . ' ' . ($item['descricao'] ?? '')) ?>"
                 data-year="<?= $item['ano'] ?>"
                 data-title="<?= strtolower($item['titulo'] ?? '') ?>">
                
                <div class="media-card-indicator" style="background: <?= $config['color'] ?>;"></div>
                
                <div class="media-card-content">
                    <div class="media-card-header">
                        <span class="media-type-badge" style="background: <?= $config['color'] ?>;">
                            <i class="bi bi-<?= $config['icon'] ?>"></i>
                            <?= $config['label'] ?>
                        </span>
                        <span class="media-year">
                            <i class="bi bi-calendar3"></i> <?= $item['ano'] ?>
                        </span>
                    </div>
                    
                    <h3 class="media-card-title"><?= htmlspecialchars($item['titulo']) ?></h3>
                    
                    <div class="media-card-author">
                        <i class="bi bi-person-fill"></i>
                        <?= htmlspecialchars($item['autor']) ?>
                    </div>
                    
                    <p class="media-card-desc"><?= htmlspecialchars($item['descricao']) ?></p>
                    
                    <div class="media-card-meta">
                        <?php if (isset($item['paginas'])): ?>
                        <span class="meta-tag">
                            <i class="bi bi-file-text"></i>
                            <?= $item['paginas'] ?> páginas
                        </span>
                        <?php endif; ?>
                        <?php if (isset($item['jogo'])): ?>
                        <span class="meta-tag game">
                            <i class="bi bi-controller"></i>
                            <?= htmlspecialchars($item['jogo']) ?>
                        </span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Comics Section -->
    <section class="media-section" id="comics" data-category="comics">
        <div class="category-header">
            <h2><i class="bi bi-journal-richtext"></i> Comics & HQs</h2>
            <p style="margin: 0; font-size: 0.8rem; opacity: 0.7;">Histórias em quadrinhos oficiais</p>
        </div>
        
        <div class="media-cards-grid">
            <?php foreach ($comics as $item): 
                $config = $typeConfig['comic'];
            ?>
            <div class="media-card-styled" 
                 data-searchable="<?= strtolower(($item['titulo'] ?? '') . ' ' . ($item['autor'] ?? '') . ' ' . ($item['descricao'] ?? '')) ?>"
                 data-year="<?= $item['ano'] ?>"
                 data-title="<?= strtolower($item['titulo'] ?? '') ?>">
                
                <div class="media-card-indicator" style="background: <?= $config['color'] ?>;"></div>
                
                <div class="media-card-content">
                    <div class="media-card-header">
                        <span class="media-type-badge" style="background: <?= $config['color'] ?>;">
                            <i class="bi bi-<?= $config['icon'] ?>"></i>
                            <?= $config['label'] ?>
                        </span>
                        <span class="media-year">
                            <i class="bi bi-calendar3"></i> <?= $item['ano'] ?>
                        </span>
                    </div>
                    
                    <h3 class="media-card-title"><?= htmlspecialchars($item['titulo']) ?></h3>
                    
                    <div class="media-card-author">
                        <i class="bi bi-person-fill"></i>
                        <?= htmlspecialchars($item['autor']) ?>
                    </div>
                    
                    <p class="media-card-desc"><?= htmlspecialchars($item['descricao']) ?></p>
                    
                    <div class="media-card-meta">
                        <?php if (isset($item['issues'])): ?>
                        <span class="meta-tag">
                            <i class="bi bi-layers"></i>
                            <?= $item['issues'] ?> issues
                        </span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Filmes Section -->
    <section class="media-section" id="filmes" data-category="filmes">
        <div class="category-header">
            <h2><i class="bi bi-film"></i> Filmes & Séries</h2>
            <p style="margin: 0; font-size: 0.8rem; opacity: 0.7;">Conteúdo audiovisual da franquia</p>
        </div>
        
        <div class="media-cards-grid">
            <?php foreach ($filmes as $item): 
                $tipo = $item['tipo'] ?? 'filme';
                $config = $typeConfig[$tipo] ?? $typeConfig['filme'];
            ?>
            <div class="media-card-styled" 
                 data-searchable="<?= strtolower(($item['titulo'] ?? '') . ' ' . ($item['diretor'] ?? '') . ' ' . ($item['descricao'] ?? '') . ' ' . ($item['elenco'] ?? '')) ?>"
                 data-year="<?= is_numeric($item['ano']) ? $item['ano'] : 9999 ?>"
                 data-title="<?= strtolower($item['titulo'] ?? '') ?>">
                
                <div class="media-card-indicator" style="background: <?= $config['color'] ?>;"></div>
                
                <div class="media-card-content">
                    <div class="media-card-header">
                        <span class="media-type-badge" style="background: <?= $config['color'] ?>;">
                            <i class="bi bi-<?= $config['icon'] ?>"></i>
                            <?= $config['label'] ?>
                        </span>
                        <span class="media-year">
                            <i class="bi bi-calendar3"></i> <?= $item['ano'] ?>
                        </span>
                    </div>
                    
                    <h3 class="media-card-title"><?= htmlspecialchars($item['titulo']) ?></h3>
                    
                    <?php if (isset($item['diretor'])): ?>
                    <div class="media-card-author">
                        <i class="bi bi-camera-reels"></i>
                        <?= htmlspecialchars($item['diretor']) ?>
                    </div>
                    <?php endif; ?>
                    
                    <p class="media-card-desc"><?= htmlspecialchars($item['descricao']) ?></p>
                    
                    <div class="media-card-meta">
                        <?php if (isset($item['duracao'])): ?>
                        <span class="meta-tag">
                            <i class="bi bi-clock"></i>
                            <?= htmlspecialchars($item['duracao']) ?>
                        </span>
                        <?php endif; ?>
                        <?php if (isset($item['plataformas']) && !empty($item['plataformas'])): ?>
                            <?php foreach ($item['plataformas'] as $plat): ?>
                            <span class="meta-tag platform">
                                <i class="bi bi-play-circle"></i>
                                <?= htmlspecialchars($plat) ?>
                            </span>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    
                    <?php if (isset($item['elenco']) && !empty($item['elenco'])): ?>
                    <div class="media-cast">
                        <i class="bi bi-people-fill"></i>
                        <?= htmlspecialchars($item['elenco']) ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Outros Section -->
    <section class="media-section" id="outros" data-category="outros">
        <div class="category-header">
            <h2><i class="bi bi-collection"></i> Artbooks & Outros</h2>
            <p style="margin: 0; font-size: 0.8rem; opacity: 0.7;">Materiais de referência e colecionáveis</p>
        </div>
        
        <div class="media-cards-grid">
            <?php foreach ($outros as $item): 
                $tipo = $item['tipo'] ?? 'artbook';
                $config = $typeConfig[$tipo] ?? $typeConfig['artbook'];
            ?>
            <div class="media-card-styled" 
                 data-searchable="<?= strtolower(($item['titulo'] ?? '') . ' ' . ($item['descricao'] ?? '')) ?>"
                 data-year="<?= $item['ano'] ?>"
                 data-title="<?= strtolower($item['titulo'] ?? '') ?>">
                
                <div class="media-card-indicator" style="background: <?= $config['color'] ?>;"></div>
                
                <div class="media-card-content">
                    <div class="media-card-header">
                        <span class="media-type-badge" style="background: <?= $config['color'] ?>;">
                            <i class="bi bi-<?= $config['icon'] ?>"></i>
                            <?= $config['label'] ?>
                        </span>
                        <span class="media-year">
                            <i class="bi bi-calendar3"></i> <?= $item['ano'] ?>
                        </span>
                    </div>
                    
                    <h3 class="media-card-title"><?= htmlspecialchars($item['titulo']) ?></h3>
                    
                    <p class="media-card-desc"><?= htmlspecialchars($item['descricao']) ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

</div>

<script>
    // Elements
    const searchInput = document.getElementById('searchInput');
    const categoryFilter = document.getElementById('categoryFilter');
    const sortFilter = document.getElementById('sortFilter');
    const sections = document.querySelectorAll('.media-section');
    const statCards = document.querySelectorAll('.media-stat-card');
    
    function filterMedia() {
        const query = searchInput.value.toLowerCase().trim();
        const category = categoryFilter.value;
        
        sections.forEach(section => {
            const sectionCategory = section.dataset.category;
            const cards = section.querySelectorAll('.media-card-styled');
            let hasVisibleCards = false;
            
            // Category filter
            if (category !== 'all' && category !== sectionCategory) {
                section.style.display = 'none';
                return;
            }
            
            cards.forEach(card => {
                const searchable = card.dataset.searchable;
                const matchesSearch = query === '' || searchable.includes(query);
                
                if (matchesSearch) {
                    card.style.display = '';
                    hasVisibleCards = true;
                } else {
                    card.style.display = 'none';
                }
            });
            
            section.style.display = hasVisibleCards ? '' : 'none';
        });
    }
    
    searchInput.addEventListener('input', filterMedia);
    
    // Category Dropdown Logic
    const categoryDropdown = document.getElementById('categoryDropdown');
    const categoryTrigger = categoryDropdown.querySelector('.custom-select-trigger');
    const categoryOptions = categoryDropdown.querySelectorAll('.custom-option');
    const categoryTriggerText = categoryTrigger.querySelector('span');
    
    categoryTrigger.addEventListener('click', (e) => {
        e.stopPropagation();
        sortDropdown.classList.remove('open');
        categoryDropdown.classList.toggle('open');
    });
    
    categoryOptions.forEach(option => {
        option.addEventListener('click', () => {
            categoryOptions.forEach(o => o.classList.remove('selected'));
            option.classList.add('selected');
            categoryTriggerText.innerHTML = option.innerHTML;
            categoryFilter.value = option.dataset.value;
            categoryDropdown.classList.remove('open');
            filterMedia();
        });
    });
    
    // Sort Dropdown Logic
    const sortDropdown = document.getElementById('sortDropdown');
    const sortTrigger = sortDropdown.querySelector('.custom-select-trigger');
    const sortOptions = sortDropdown.querySelectorAll('.custom-option');
    const sortTriggerText = sortTrigger.querySelector('span');
    
    sortTrigger.addEventListener('click', (e) => {
        e.stopPropagation();
        categoryDropdown.classList.remove('open');
        sortDropdown.classList.toggle('open');
    });
    
    sortOptions.forEach(option => {
        option.addEventListener('click', () => {
            sortOptions.forEach(o => o.classList.remove('selected'));
            option.classList.add('selected');
            sortTriggerText.innerHTML = option.innerHTML;
            sortFilter.value = option.dataset.value;
            sortDropdown.classList.remove('open');
            // Sorting could be implemented here
        });
    });
    
    // Stat cards click to filter
    statCards.forEach(card => {
        card.addEventListener('click', () => {
            const cat = card.dataset.category;
            categoryFilter.value = cat;
            const option = categoryDropdown.querySelector(`[data-value="${cat}"]`);
            if (option) {
                categoryOptions.forEach(o => o.classList.remove('selected'));
                option.classList.add('selected');
                categoryTriggerText.innerHTML = option.innerHTML;
            }
            filterMedia();
        });
    });
    
    // Close dropdowns when clicking outside
    document.addEventListener('click', (e) => {
        if (!categoryDropdown.contains(e.target)) {
            categoryDropdown.classList.remove('open');
        }
        if (!sortDropdown.contains(e.target)) {
            sortDropdown.classList.remove('open');
        }
    });
</script>
