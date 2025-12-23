<div class="title">Personagens</div>

<div class="description">
    <p>Conheça os protagonistas, mentores e antagonistas que moldaram a história da Irmandade.</p>
</div>

<!-- Busca de Personagens -->
<div class="search-box">
    <input type="text" class="search-input" id="searchInput" placeholder="Buscar personagem por nome, era ou nacionalidade...">
</div>

<!-- Navegação de Categorias -->
<div class="character-nav">
    <button class="char-nav-btn active" data-target="all">
        <i class="bi bi-grid-fill"></i>
        Todos
    </button>
    <?php foreach ($categories as $key => $cat): ?>
    <button class="char-nav-btn" data-target="<?= $key ?>">
        <i class="bi <?= $cat['icon'] ?>"></i>
        <?= htmlspecialchars($cat['titulo']) ?>
    </button>
    <?php endforeach; ?>
</div>

<div id="charactersContainer">
    <?php foreach ($characters as $key => $cat): ?>
    <div class="category-section" id="<?= $key ?>" data-category="<?= $key ?>">
        <div class="category-header">
            <i class="bi <?= $cat['icon'] ?? 'bi-person' ?>"></i>
            <h2><?= htmlspecialchars($cat['titulo']) ?></h2>
            <p style="margin: 0; font-size: 0.8rem; opacity: 0.7;"><?= htmlspecialchars($cat['desc']) ?></p>
        </div>
        
        <div class="character-grid">
            <?php foreach ($cat['personagens'] as $char): ?>
            <div class="character-card" data-searchable="<?= strtolower($char['nome'] . ' ' . $char['era'] . ' ' . $char['jogo'] . ' ' . $char['nacionalidade']) ?>">
                <div class="char-header">
                    <h3><?= htmlspecialchars($char['nome']) ?></h3>
                    <span class="char-type"><?= htmlspecialchars($char['tipo']) ?></span>
                </div>
                
                <div class="char-body">
                    <div class="char-meta">
                        <div class="meta-item">
                            <i class="bi bi-hourglass-split"></i>
                            <?= htmlspecialchars($char['era']) ?>
                        </div>
                        <div class="meta-item">
                            <i class="bi bi-geo-alt"></i>
                            <?= htmlspecialchars($char['nacionalidade']) ?>
                        </div>
                        <div class="meta-item">
                            <i class="bi bi-controller"></i>
                            <?= htmlspecialchars($char['jogo']) ?>
                        </div>
                    </div>
                    
                    <p class="char-desc"><?= htmlspecialchars($char['desc']) ?></p>
                    
                    <?php if (isset($char['akas'])): ?>
                    <div class="char-akas">
                        <strong>Conhecido como:</strong> <?= implode(', ', $char['akas']) ?>
                    </div>
                    <?php endif; ?>
                    
                    <div class="char-actions">
                        <button class="char-btn favorite-btn" 
                                data-favorite-id="char_<?= md5($char['nome']) ?>" 
                                data-favorite-type="character" 
                                data-favorite-name="<?= htmlspecialchars($char['nome']) ?>">
                            <i class="bi bi-heart"></i> Favoritar
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
    // Character Search & Filter
    const searchInput = document.getElementById('searchInput');
    const navBtns = document.querySelectorAll('.char-nav-btn');
    const sections = document.querySelectorAll('.category-section');
    
    // Filter by Category
    navBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            navBtns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            
            const target = btn.dataset.target;
            
            sections.forEach(section => {
                const category = section.dataset.category;
                if (target === 'all' || target === category) {
                    section.classList.remove('hidden');
                } else {
                    section.classList.add('hidden');
                }
            });
        });
    });
    
    // Search
    searchInput.addEventListener('input', function() {
        const query = this.value.toLowerCase().trim();
        
        sections.forEach(section => {
            const cards = section.querySelectorAll('.character-card');
            let hasVisibleCards = false;
            
            cards.forEach(card => {
                const searchable = card.dataset.searchable;
                if (query === '' || searchable.includes(query)) {
                    card.style.display = '';
                    hasVisibleCards = true;
                } else {
                    card.style.display = 'none';
                }
            });
            
            // Show/hide section based on matches if searching
            if (query !== '') {
                section.style.display = hasVisibleCards ? '' : 'none';
                // Reset category filter visual when searching
                navBtns.forEach(b => b.classList.remove('active'));
                navBtns[0].classList.add('active');
            } else {
                section.style.display = '';
            }
        });
    });
</script>
