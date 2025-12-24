<div class="title">Timeline Completa</div>

<div class="description">
    <p>Acompanhe a cronologia do universo Assassin's Creed através dos séculos, desde a Era Isu até os dias modernos.</p>
</div>

<!-- Barra de Busca e Filtros -->
<div class="search-filters-container">
    <input type="text" class="search-input" id="searchInput" placeholder="Buscar por título, personagem ou descrição...">
    
    <div class="filters-row">
        <div class="filter-group">
            <label>Visualização</label>
            <div class="custom-select-wrapper" id="viewDropdown">
                <div class="custom-select-trigger">
                    <span><i class="bi bi-clock-history"></i> Cronologia Histórica</span>
                    <i class="bi bi-chevron-down"></i>
                </div>
                <div class="custom-options">
                    <div class="custom-option selected" data-value="historica">
                        <i class="bi bi-clock-history"></i> Cronologia Histórica
                    </div>
                    <div class="custom-option" data-value="lancamentos">
                        <i class="bi bi-calendar-check"></i> Ordem de Lançamento
                    </div>
                </div>
                <input type="hidden" id="viewFilter" value="historica">
            </div>
        </div>
        
        <div class="filter-group">
            <label>Tipo</label>
            <div class="custom-select-wrapper" id="typeDropdown">
                <div class="custom-select-trigger">
                    <span><i class="bi bi-grid-fill"></i> Todos</span>
                    <i class="bi bi-chevron-down"></i>
                </div>
                <div class="custom-options">
                    <div class="custom-option selected" data-value=""><i class="bi bi-grid-fill"></i> Todos</div>
                    <div class="custom-option" data-value="jogo"><i class="bi bi-controller"></i> Jogos</div>
                    <div class="custom-option" data-value="livro"><i class="bi bi-book"></i> Livros</div>
                    <div class="custom-option" data-value="comic"><i class="bi bi-journal-richtext"></i> Comics</div>
                    <div class="custom-option" data-value="filme"><i class="bi bi-film"></i> Filmes</div>
                    <div class="custom-option" data-value="evento"><i class="bi bi-flag"></i> Eventos</div>
                </div>
                <input type="hidden" id="typeFilter" value="">
            </div>
        </div>
    </div>
</div>

<?php
// Type icons and colors
$typeConfig = [
    'jogo' => ['icon' => 'controller', 'color' => '#8B0000', 'label' => 'Jogo'],
    'livro' => ['icon' => 'book', 'color' => '#1a5276', 'label' => 'Livro'],
    'comic' => ['icon' => 'journal-richtext', 'color' => '#7d3c98', 'label' => 'Comic'],
    'filme' => ['icon' => 'film', 'color' => '#b9770e', 'label' => 'Filme'],
    'evento' => ['icon' => 'flag', 'color' => '#1e8449', 'label' => 'Evento'],
    'artbook' => ['icon' => 'palette', 'color' => '#922b21', 'label' => 'Artbook'],
];
?>

<!-- Timeline Histórica -->
<div id="timeline-historica" class="timeline-view">
    <div class="timeline-enhanced">
        <?php foreach ($timelineHistorica as $index => $evento): 
            $tipo = $evento['tipo'] ?? 'evento';
            $config = $typeConfig[$tipo] ?? $typeConfig['evento'];
            $isGame = $tipo === 'jogo';
        ?>
        <div class="timeline-item-enhanced <?= $isGame ? 'highlight' : '' ?>" 
             data-searchable="<?= strtolower(($evento['titulo'] ?? '') . ' ' . ($evento['descricao'] ?? '') . ' ' . ($evento['protagonista'] ?? '')) ?>"
             data-type="<?= $tipo ?>">
            
            <div class="timeline-marker" style="background: <?= $config['color'] ?>;">
                <i class="bi bi-<?= $config['icon'] ?>"></i>
            </div>
            
            <div class="timeline-card">
                <div class="timeline-card-header">
                    <span class="timeline-date-badge"><?= htmlspecialchars($evento['ano']) ?></span>
                    <span class="timeline-type-badge" style="background: <?= $config['color'] ?>;">
                        <?= $config['label'] ?>
                    </span>
                </div>
                
                <h3 class="timeline-card-title">
                    <?php if (isset($evento['icone'])): ?>
                    <i class="bi bi-<?= $evento['icone'] ?>"></i>
                    <?php endif; ?>
                    <?= htmlspecialchars($evento['titulo']) ?>
                </h3>
                
                <p class="timeline-card-desc"><?= htmlspecialchars($evento['descricao']) ?></p>
                
                <?php if (isset($evento['protagonista'])): ?>
                <div class="timeline-protagonist">
                    <i class="bi bi-person-fill"></i>
                    <?= htmlspecialchars($evento['protagonista']) ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Timeline Lançamentos -->
<div id="timeline-lancamentos" class="timeline-view hidden">
    <?php foreach ($timelineLancamentos as $ano => $itens): ?>
    <div class="release-year-section" data-year="<?= $ano ?>">
        <div class="year-header-styled">
            <span class="year-number"><?= $ano ?></span>
            <span class="year-count"><?= count($itens) ?> <?= count($itens) == 1 ? 'lançamento' : 'lançamentos' ?></span>
        </div>
        
        <div class="releases-grid">
            <?php foreach ($itens as $item): 
                $tipo = $item['tipo'] ?? 'jogo';
                $config = $typeConfig[$tipo] ?? $typeConfig['jogo'];
            ?>
            <div class="release-card-styled" 
                 data-searchable="<?= strtolower(($item['titulo'] ?? '') . ' ' . ($item['data'] ?? '')) ?>"
                 data-type="<?= $tipo ?>">
                
                <div class="release-type-indicator" style="background: <?= $config['color'] ?>;"></div>
                
                <div class="release-content">
                    <div class="release-header">
                        <span class="release-type-badge" style="background: <?= $config['color'] ?>;">
                            <i class="bi bi-<?= $config['icon'] ?>"></i>
                            <?= $config['label'] ?>
                        </span>
                        <?php if (isset($item['data'])): ?>
                        <span class="release-date">
                            <i class="bi bi-calendar3"></i>
                            <?= htmlspecialchars($item['data']) ?>
                        </span>
                        <?php endif; ?>
                    </div>
                    
                    <h4 class="release-title"><?= htmlspecialchars($item['titulo']) ?></h4>
                    
                    <?php if (isset($item['plataformas']) && !empty($item['plataformas'])): 
                        $platforms = is_array($item['plataformas']) ? $item['plataformas'] : explode(', ', $item['plataformas']);
                    ?>
                    <div class="release-platforms">
                        <?php foreach ($platforms as $plat): ?>
                        <span class="platform-tag"><?= trim($plat) ?></span>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<script>
    // Elements
    const searchInput = document.getElementById('searchInput');
    const viewFilter = document.getElementById('viewFilter');
    const typeFilter = document.getElementById('typeFilter');
    const timelineHistorica = document.getElementById('timeline-historica');
    const timelineLancamentos = document.getElementById('timeline-lancamentos');
    
    function filterContent() {
        const query = searchInput.value.toLowerCase().trim();
        const type = typeFilter.value;
        const view = viewFilter.value;
        
        // Get active timeline
        const activeTimeline = view === 'historica' ? timelineHistorica : timelineLancamentos;
        const items = activeTimeline.querySelectorAll('[data-searchable]');
        
        items.forEach(item => {
            const searchable = item.dataset.searchable;
            const itemType = item.dataset.type;
            
            const matchesSearch = query === '' || searchable.includes(query);
            const matchesType = type === '' || itemType === type;
            
            item.style.display = (matchesSearch && matchesType) ? '' : 'none';
        });
        
        // For releases view, hide empty year sections
        if (view === 'lancamentos') {
            const sections = timelineLancamentos.querySelectorAll('.release-year-section');
            sections.forEach(section => {
                const visibleCards = section.querySelectorAll('.release-card-styled:not([style*="display: none"])');
                section.style.display = visibleCards.length > 0 ? '' : 'none';
            });
        }
    }
    
    function switchView(newView) {
        if (newView === 'historica') {
            timelineHistorica.classList.remove('hidden');
            timelineLancamentos.classList.add('hidden');
        } else {
            timelineHistorica.classList.add('hidden');
            timelineLancamentos.classList.remove('hidden');
        }
        filterContent();
    }
    
    searchInput.addEventListener('input', filterContent);
    
    // View Dropdown Logic
    const viewDropdown = document.getElementById('viewDropdown');
    const viewTrigger = viewDropdown.querySelector('.custom-select-trigger');
    const viewOptions = viewDropdown.querySelectorAll('.custom-option');
    const viewTriggerText = viewTrigger.querySelector('span');
    
    viewTrigger.addEventListener('click', (e) => {
        e.stopPropagation();
        typeDropdown.classList.remove('open');
        viewDropdown.classList.toggle('open');
    });
    
    viewOptions.forEach(option => {
        option.addEventListener('click', () => {
            viewOptions.forEach(o => o.classList.remove('selected'));
            option.classList.add('selected');
            viewTriggerText.innerHTML = option.innerHTML;
            viewFilter.value = option.dataset.value;
            viewDropdown.classList.remove('open');
            switchView(option.dataset.value);
        });
    });
    
    // Type Dropdown Logic
    const typeDropdown = document.getElementById('typeDropdown');
    const typeTrigger = typeDropdown.querySelector('.custom-select-trigger');
    const typeOptions = typeDropdown.querySelectorAll('.custom-option');
    const typeTriggerText = typeTrigger.querySelector('span');
    
    typeTrigger.addEventListener('click', (e) => {
        e.stopPropagation();
        viewDropdown.classList.remove('open');
        typeDropdown.classList.toggle('open');
    });
    
    typeOptions.forEach(option => {
        option.addEventListener('click', () => {
            typeOptions.forEach(o => o.classList.remove('selected'));
            option.classList.add('selected');
            typeTriggerText.innerHTML = option.innerHTML;
            typeFilter.value = option.dataset.value;
            typeDropdown.classList.remove('open');
            filterContent();
        });
    });
    
    // Close dropdowns when clicking outside
    document.addEventListener('click', (e) => {
        if (!viewDropdown.contains(e.target)) {
            viewDropdown.classList.remove('open');
        }
        if (!typeDropdown.contains(e.target)) {
            typeDropdown.classList.remove('open');
        }
    });
</script>
