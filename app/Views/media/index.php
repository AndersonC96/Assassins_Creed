<?php
// Calculate totals
$totalRomances = count($romances);
$totalComics = count($comics);
$totalFilmes = count($filmes);
$totalOutros = count($outros);
?>
<div class="title">Livros & Mídia</div>

<div class="description">
    <p>Explore o vasto universo expandido de <strong>Assassin's Creed</strong> através de romances, histórias em quadrinhos, filmes e materiais de referência.</p>
</div>

<!-- Estatísticas -->
<div class="stats-bar">
    <div class="stat-card">
        <div class="stat-number"><?= $totalRomances ?></div>
        <div class="stat-label">Romances</div>
    </div>
    <div class="stat-card">
        <div class="stat-number"><?= $totalComics ?></div>
        <div class="stat-label">Comics/HQs</div>
    </div>
    <div class="stat-card">
        <div class="stat-number"><?= $totalFilmes ?></div>
        <div class="stat-label">Filmes & Séries</div>
    </div>
    <div class="stat-card">
        <div class="stat-number"><?= $totalOutros ?></div>
        <div class="stat-label">Art Books</div>
    </div>
</div>

<!-- Busca -->
<div class="search-box">
    <input type="text" class="search-input" id="searchInput" placeholder="Buscar por título, autor ou descrição...">
</div>

<!-- Navegação de Categorias -->
<div class="media-nav">
    <button class="media-nav-btn active" data-target="all">
        <i class="bi bi-grid-3x3-gap-fill"></i> Todos
    </button>
    <button class="media-nav-btn" data-target="romances">
        <i class="bi bi-book"></i> Romances
    </button>
    <button class="media-nav-btn" data-target="comics">
        <i class="bi bi-journal-richtext"></i> Comics
    </button>
    <button class="media-nav-btn" data-target="filmes">
        <i class="bi bi-film"></i> Filmes
    </button>
    <button class="media-nav-btn" data-target="outros">
        <i class="bi bi-collection"></i> Outros
    </button>
</div>

<!-- Seções de Mídia -->
<div id="mediaContainer">

    <!-- Romances -->
    <section class="media-section" id="romances" data-category="romances">
        <div class="section-header">
            <i class="bi bi-book-fill"></i>
            <h2>Romances</h2>
            <span class="badge"><?= $totalRomances ?></span>
        </div>
        <div class="media-grid">
            <?php foreach ($romances as $livro): ?>
            <div class="media-card" data-searchable="<?= strtolower($livro['titulo'] . ' ' . $livro['autor']) ?>">
                <span class="type-badge romance">Romance</span>
                <div class="media-card-header">
                    <i class="bi bi-book"></i>
                    <div class="title-info">
                        <h3><?= htmlspecialchars($livro['titulo']) ?></h3>
                        <div class="subtitle"><?= htmlspecialchars($livro['autor']) ?></div>
                    </div>
                </div>
                <div class="media-card-body">
                    <div class="media-meta">
                        <span class="meta-item"><i class="bi bi-calendar3"></i> <?= $livro['ano'] ?></span>
                        <span class="meta-item"><i class="bi bi-file-text"></i> <?= $livro['paginas'] ?> pág.</span>
                    </div>
                    <p class="media-desc"><?= htmlspecialchars($livro['descricao']) ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Comics -->
    <section class="media-section" id="comics" data-category="comics">
        <div class="section-header">
            <i class="bi bi-journal-richtext"></i>
            <h2>Comics & HQs</h2>
            <span class="badge"><?= $totalComics ?></span>
        </div>
        <div class="media-grid">
            <?php foreach ($comics as $comic): ?>
            <div class="media-card" data-searchable="<?= strtolower($comic['titulo'] . ' ' . $comic['autor']) ?>">
                <span class="type-badge comic">Comic</span>
                <div class="media-card-header">
                    <i class="bi bi-journal-richtext"></i>
                    <div class="title-info">
                        <h3><?= htmlspecialchars($comic['titulo']) ?></h3>
                        <div class="subtitle"><?= htmlspecialchars($comic['autor']) ?></div>
                    </div>
                </div>
                <div class="media-card-body">
                    <div class="media-meta">
                        <span class="meta-item"><i class="bi bi-calendar3"></i> <?= $comic['ano'] ?></span>
                        <span class="meta-item"><i class="bi bi-layers"></i> <?= $comic['issues'] ?> issues</span>
                    </div>
                    <p class="media-desc"><?= htmlspecialchars($comic['descricao']) ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Outras seções (Filmes, Outros) simplificadas para exemplo -->
    <!-- ... -->
</div>

<script>
    // Media filtering logic (similar to previous)
    // ...
</script>
