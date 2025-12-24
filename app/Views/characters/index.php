<div class="title">Personagens</div>

<div class="description">
    <p>Conheça os protagonistas, mentores e antagonistas que moldaram a história da Irmandade.</p>
</div>

<!-- Barra de Busca e Filtros -->
<div class="search-filters-container">
    <input type="text" class="search-input" id="searchInput" placeholder="Buscar personagem por nome, era ou nacionalidade...">
    
    <div class="filters-row">
        <div class="filter-group">
            <label>Categoria</label>
            <div class="custom-select-wrapper" id="categoryDropdown">
                <div class="custom-select-trigger">
                    <span><i class="bi bi-grid-fill"></i> Todas</span>
                    <i class="bi bi-chevron-down"></i>
                </div>
                <div class="custom-options">
                    <div class="custom-option selected" data-value="all"><i class="bi bi-grid-fill"></i> Todas</div>
                    <?php foreach ($categories as $key => $cat): ?>
                    <div class="custom-option" data-value="<?= $key ?>">
                        <i class="bi <?= $cat['icon'] ?>"></i> <?= htmlspecialchars($cat['titulo']) ?>
                    </div>
                    <?php endforeach; ?>
                </div>
                <input type="hidden" id="categoryFilter" value="all">
            </div>
        </div>
        
        <div class="filter-group">
            <label>Tipo</label>
            <div class="custom-select-wrapper" id="typeDropdown">
                <div class="custom-select-trigger">
                    <span><i class="bi bi-person-badge"></i> Todos</span>
                    <i class="bi bi-chevron-down"></i>
                </div>
                <div class="custom-options">
                    <div class="custom-option selected" data-value=""><i class="bi bi-person-badge"></i> Todos</div>
                    <div class="custom-option" data-value="Mentor"><i class="bi bi-mortarboard"></i> Mentor</div>
                    <div class="custom-option" data-value="Assassino"><i class="bi bi-person-arms-up"></i> Assassino</div>
                    <div class="custom-option" data-value="Templário"><i class="bi bi-shield-shaded"></i> Templário</div>
                    <div class="custom-option" data-value="Histórico"><i class="bi bi-book"></i> Personagem Histórico</div>
                    <div class="custom-option" data-value="Moderno"><i class="bi bi-phone"></i> Mundo Moderno</div>
                </div>
                <input type="hidden" id="typeFilter" value="">
            </div>
        </div>
    </div>
</div>

<?php
// Helper function for color brightness
function adjustBrightness($hex, $percent) {
    $hex = ltrim($hex, '#');
    if (strlen($hex) === 3) {
        $hex = $hex[0].$hex[0].$hex[1].$hex[1].$hex[2].$hex[2];
    }
    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));
    
    $r = min(255, max(0, $r + ($percent * 2.55)));
    $g = min(255, max(0, $g + ($percent * 2.55)));
    $b = min(255, max(0, $b + ($percent * 2.55)));
    
    return sprintf("#%02x%02x%02x", (int)$r, (int)$g, (int)$b);
}

// Type badge colors
$typeColors = [
    'Mentor' => '#8B0000',
    'Assassino' => '#1a5276',
    'Assassina' => '#1a5276',
    'Templário' => '#7d3c98',
    'Templária' => '#7d3c98',
    'Grão-Mestre' => '#922B21',
    'Aliado' => '#1e8449',
    'Personagem Histórico' => '#b9770e',
    'Personagem' => '#555',
    'Protagonista Moderno' => '#2471a3',
    'Protagonista Moderna' => '#2471a3',
    'Suporte' => '#117864',
    'Fundador' => '#8B0000',
    'Fundadora' => '#8B0000',
    'Medjay/Fundador' => '#8B0000',
    'Oculto' => '#1a5276',
    'Shinobi' => '#1a5276',
    'Samurai' => '#8B0000',
    'Viking/Aliado dos Ocultos' => '#b9770e',
    'Mercenária/Imortal' => '#7d3c98',
    'Mercenário/Antagonista' => '#7d3c98',
    'Pirata/Assassino' => '#1a5276',
    'Ex-Assassino/Templário' => '#7d3c98',
    'Viking/Isu' => '#b9770e',
    'Mentor Traidor' => '#922B21',
    'Comandante Templário' => '#922B21',
    'Líder da Ordem' => '#922B21',
    'Aliada/Inimiga' => '#b9770e',
    'Inimigo' => '#922B21',
    'Neutro' => '#666',
];
?>

<div id="charactersContainer">
    <?php foreach ($characters as $key => $cat): ?>
    <div class="category-section" id="<?= $key ?>" data-category="<?= $key ?>">
        <div class="category-header">
            <h2><i class="bi <?= $cat['icon'] ?? 'bi-person' ?>"></i> <?= htmlspecialchars($cat['titulo']) ?></h2>
            <p style="margin: 0; font-size: 0.8rem; opacity: 0.7;"><?= htmlspecialchars($cat['desc']) ?></p>
        </div>
        
        <div class="characters-grid">
            <?php foreach ($cat['personagens'] as $char): 
                $badgeColor = $typeColors[$char['tipo']] ?? '#555';
                
                // Generate initials for avatar fallback
                $nameParts = explode(' ', $char['nome']);
                $initials = '';
                if (count($nameParts) >= 2) {
                    $initials = strtoupper(substr($nameParts[0], 0, 1) . substr(end($nameParts), 0, 1));
                } else {
                    $initials = strtoupper(substr($char['nome'], 0, 2));
                }
                
                // Check if we have an image from API
                $hasImage = isset($char['image']) && !empty($char['image']);
            ?>
            <div class="character-card-styled" 
                 data-searchable="<?= strtolower($char['nome'] . ' ' . ($char['era'] ?? '') . ' ' . ($char['jogo'] ?? '') . ' ' . ($char['nacionalidade'] ?? '')) ?>"
                 data-type="<?= htmlspecialchars($char['tipo'] ?? 'Personagem') ?>">
                
                <?php if ($hasImage): ?>
                <!-- Card with Image from API -->
                <div class="char-avatar-image">
                    <img src="<?= htmlspecialchars($char['image_thumb'] ?? $char['image']) ?>" 
                         alt="<?= htmlspecialchars($char['nome']) ?>"
                         loading="lazy">
                    <span class="char-type-badge" style="background: <?= $badgeColor ?>;">
                        <?= htmlspecialchars($char['tipo'] ?? 'Personagem') ?>
                    </span>
                </div>
                <?php else: ?>
                <!-- Card with Initials Fallback -->
                <div class="char-avatar" style="background: linear-gradient(135deg, <?= $badgeColor ?>, <?= adjustBrightness($badgeColor, 30) ?>);">
                    <span class="char-initials"><?= $initials ?></span>
                    <span class="char-type-badge" style="background: <?= $badgeColor ?>;">
                        <?= htmlspecialchars($char['tipo'] ?? 'Personagem') ?>
                    </span>
                </div>
                <?php endif; ?>
                
                <div class="char-content">
                    <h3 class="char-name"><?= htmlspecialchars($char['nome']) ?></h3>
                    
                    <div class="char-meta-tags">
                        <?php if (!empty($char['era'])): ?>
                        <span class="meta-tag era">
                            <i class="bi bi-hourglass-split"></i>
                            <?= htmlspecialchars($char['era']) ?>
                        </span>
                        <?php endif; ?>
                        <?php if (!empty($char['nacionalidade'])): ?>
                        <span class="meta-tag location">
                            <i class="bi bi-geo-alt"></i>
                            <?= htmlspecialchars($char['nacionalidade']) ?>
                        </span>
                        <?php endif; ?>
                        <?php if (!empty($char['jogo'])): ?>
                        <span class="meta-tag game">
                            <i class="bi bi-controller"></i>
                            <?= htmlspecialchars($char['jogo']) ?>
                        </span>
                        <?php endif; ?>
                    </div>
                    
                    <p class="char-description"><?= htmlspecialchars($char['desc'] ?? $char['desc_en'] ?? '') ?></p>
                    
                    <?php if (isset($char['akas']) && !empty($char['akas'])): ?>
                    <div class="char-aliases">
                        <strong>Conhecido como:</strong> <?= implode(', ', $char['akas']) ?>
                    </div>
                    <?php endif; ?>
                    
                    <?php 
                    // Build character URL using igdb_id if available, otherwise use name
                    $charId = isset($char['igdb_id']) ? $char['igdb_id'] : urlencode($char['nome']);
                    $charUrl = $this->config('app.url') . '/characters/' . $charId;
                    ?>
                    
                    <div class="char-actions">
                        <a href="<?= $charUrl ?>" class="view-details-btn">
                            <i class="bi bi-eye"></i> Ver Detalhes
                        </a>
                        <button class="favorite-btn" 
                                data-favorite-id="char_<?= isset($char['igdb_id']) ? $char['igdb_id'] : md5($char['nome']) ?>" 
                                data-favorite-type="character" 
                                data-favorite-name="<?= htmlspecialchars($char['nome']) ?>">
                            <i class="bi bi-heart"></i>
                        </button>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<script>
    // Filter Logic
    const searchInput = document.getElementById('searchInput');
    const categoryFilter = document.getElementById('categoryFilter');
    const typeFilter = document.getElementById('typeFilter');
    const sections = document.querySelectorAll('.category-section');
    
    function filterCharacters() {
        const query = searchInput.value.toLowerCase().trim();
        const category = categoryFilter.value;
        const type = typeFilter.value;
        
        sections.forEach(section => {
            const sectionCategory = section.dataset.category;
            const cards = section.querySelectorAll('.character-card-styled');
            let hasVisibleCards = false;
            
            // Category filter
            if (category !== 'all' && category !== sectionCategory) {
                section.style.display = 'none';
                return;
            }
            
            cards.forEach(card => {
                const searchable = card.dataset.searchable;
                const cardType = card.dataset.type;
                
                const matchesSearch = query === '' || searchable.includes(query);
                const matchesType = type === '' || cardType.toLowerCase().includes(type.toLowerCase());
                
                if (matchesSearch && matchesType) {
                    card.style.display = '';
                    hasVisibleCards = true;
                } else {
                    card.style.display = 'none';
                }
            });
            
            section.style.display = hasVisibleCards ? '' : 'none';
        });
    }
    
    searchInput.addEventListener('input', filterCharacters);
    
    // Category Dropdown Logic
    const categoryDropdown = document.getElementById('categoryDropdown');
    const categoryTrigger = categoryDropdown.querySelector('.custom-select-trigger');
    const categoryOptions = categoryDropdown.querySelectorAll('.custom-option');
    const categoryTriggerText = categoryTrigger.querySelector('span');
    
    categoryTrigger.addEventListener('click', (e) => {
        e.stopPropagation();
        typeDropdown.classList.remove('open');
        categoryDropdown.classList.toggle('open');
    });
    
    categoryOptions.forEach(option => {
        option.addEventListener('click', () => {
            categoryOptions.forEach(o => o.classList.remove('selected'));
            option.classList.add('selected');
            categoryTriggerText.innerHTML = option.innerHTML;
            categoryFilter.value = option.dataset.value;
            categoryDropdown.classList.remove('open');
            filterCharacters();
        });
    });
    
    // Type Dropdown Logic
    const typeDropdown = document.getElementById('typeDropdown');
    const typeTrigger = typeDropdown.querySelector('.custom-select-trigger');
    const typeOptions = typeDropdown.querySelectorAll('.custom-option');
    const typeTriggerText = typeTrigger.querySelector('span');
    
    typeTrigger.addEventListener('click', (e) => {
        e.stopPropagation();
        categoryDropdown.classList.remove('open');
        typeDropdown.classList.toggle('open');
    });
    
    typeOptions.forEach(option => {
        option.addEventListener('click', () => {
            typeOptions.forEach(o => o.classList.remove('selected'));
            option.classList.add('selected');
            typeTriggerText.innerHTML = option.innerHTML;
            typeFilter.value = option.dataset.value;
            typeDropdown.classList.remove('open');
            filterCharacters();
        });
    });
    
    // Close dropdowns when clicking outside
    document.addEventListener('click', (e) => {
        if (!categoryDropdown.contains(e.target)) {
            categoryDropdown.classList.remove('open');
        }
        if (!typeDropdown.contains(e.target)) {
            typeDropdown.classList.remove('open');
        }
    });
</script>
