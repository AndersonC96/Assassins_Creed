<?php
$baseUrl = $this->config('app.url');

// Type badge colors
$typeBadgeColors = [
    'assassino' => '#8B0000',
    'templario' => '#1a5276',
    'mentor' => '#1e8449',
    'historico' => '#b9770e',
    'coadjuvante' => '#7d3c98',
    'moderno' => '#2c3e50',
    'grao-mestre' => '#922b21',
];

$charType = strtolower($character['tipo'] ?? 'assassino');
$badgeColor = $typeBadgeColors[$charType] ?? '#666';

// Generate initials for avatar fallback
$initials = '';
$nameParts = explode(' ', $character['nome']);
if (count($nameParts) >= 2) {
    $initials = strtoupper(substr($nameParts[0], 0, 1) . substr(end($nameParts), 0, 1));
} else {
    $initials = strtoupper(substr($character['nome'], 0, 2));
}

// Avatar colors based on type
$avatarColors = [
    'assassino' => ['#8B0000', '#a52a2a'],
    'templario' => ['#1a5276', '#2471a3'],
    'mentor' => ['#1e8449', '#27ae60'],
    'historico' => ['#b9770e', '#d4ac0d'],
    'moderno' => ['#2c3e50', '#34495e'],
];
$avatarGradient = $avatarColors[$charType] ?? ['#555', '#777'];

$hasImage = !empty($character['image']) || !empty($character['image_thumb']);
$imageUrl = $character['image'] ?? ($character['image_thumb'] ?? '');
?>

<!-- Breadcrumbs -->
<?php if (!empty($breadcrumbs)): ?>
<nav class="breadcrumbs" aria-label="Breadcrumb">
    <?php foreach ($breadcrumbs as $index => $crumb): ?>
        <?php if ($crumb['url']): ?>
            <a href="<?= $crumb['url'] ?>"><?= htmlspecialchars($crumb['label']) ?></a>
            <i class="bi bi-chevron-right"></i>
        <?php else: ?>
            <span class="current"><?= htmlspecialchars($crumb['label']) ?></span>
        <?php endif; ?>
    <?php endforeach; ?>
</nav>
<?php endif; ?>

<div class="character-detail-container">
    <!-- Character Header -->
    <div class="character-detail-header">
        <!-- Avatar/Image -->
        <div class="character-detail-avatar">
            <?php if ($hasImage): ?>
            <div class="character-image-large" style="background-image: url('<?= htmlspecialchars($imageUrl) ?>');">
                <div class="image-overlay"></div>
            </div>
            <?php else: ?>
            <div class="character-initials-large" style="background: linear-gradient(135deg, <?= $avatarGradient[0] ?>, <?= $avatarGradient[1] ?>);">
                <span><?= $initials ?></span>
            </div>
            <?php endif; ?>
        </div>
        
        <!-- Character Info -->
        <div class="character-detail-info">
            <div class="character-badges">
                <span class="char-type-badge" style="background: <?= $badgeColor ?>;">
                    <?= strtoupper($character['tipo'] ?? 'Personagem') ?>
                </span>
                <?php if (!empty($character['era'])): ?>
                <span class="char-era-badge">
                    <i class="bi bi-hourglass-split"></i>
                    <?= htmlspecialchars($character['era']) ?>
                </span>
                <?php endif; ?>
            </div>
            
            <h1 class="character-detail-name"><?= htmlspecialchars($character['nome']) ?></h1>
            
            <?php if (!empty($character['nacionalidade'])): ?>
            <div class="character-nationality">
                <i class="bi bi-geo-alt-fill"></i>
                <?= htmlspecialchars($character['nacionalidade']) ?>
            </div>
            <?php endif; ?>
            
            <!-- Meta Info -->
            <div class="character-meta-grid">
                <?php if (!empty($character['jogo'])): ?>
                <div class="meta-item">
                    <i class="bi bi-controller"></i>
                    <span class="meta-label">Primeira Aparição</span>
                    <span class="meta-value"><?= htmlspecialchars($character['jogo']) ?></span>
                </div>
                <?php endif; ?>
                
                <?php if (!empty($character['gender'])): ?>
                <div class="meta-item">
                    <i class="bi bi-person"></i>
                    <span class="meta-label">Gênero</span>
                    <span class="meta-value"><?= htmlspecialchars($character['gender']) ?></span>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- Character Description -->
    <div class="character-detail-body">
        <div class="character-section">
            <h2><i class="bi bi-file-text"></i> Biografia</h2>
            <div class="character-biography">
                <?= nl2br(htmlspecialchars($character['descricao'] ?? 'Sem descrição disponível.')) ?>
            </div>
        </div>
        
        <?php if (!empty($character['description'])): ?>
        <div class="character-section">
            <h2><i class="bi bi-translate"></i> Descrição (EN)</h2>
            <div class="character-biography en">
                <?= nl2br(htmlspecialchars($character['description'])) ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
    
    <!-- Related Characters -->
    <?php if (!empty($relatedCharacters)): ?>
    <div class="related-section">
        <h2><i class="bi bi-people"></i> Personagens Relacionados</h2>
        <div class="related-grid">
            <?php foreach ($relatedCharacters as $related): 
                $relatedInitials = '';
                $nameParts = explode(' ', $related['nome']);
                if (count($nameParts) >= 2) {
                    $relatedInitials = strtoupper(substr($nameParts[0], 0, 1) . substr(end($nameParts), 0, 1));
                } else {
                    $relatedInitials = strtoupper(substr($related['nome'], 0, 2));
                }
                $relatedType = strtolower($related['tipo'] ?? 'assassino');
                $relatedGradient = $avatarColors[$relatedType] ?? ['#555', '#777'];
                $relatedHasImage = !empty($related['image']) || !empty($related['image_thumb']);
                $relatedImage = $related['image'] ?? ($related['image_thumb'] ?? '');
                $relatedId = $related['id'] ?? urlencode($related['nome']);
            ?>
            <a href="<?= $baseUrl ?>/characters/<?= $relatedId ?>" class="related-card">
                <?php if ($relatedHasImage): ?>
                <div class="related-avatar-img" style="background-image: url('<?= htmlspecialchars($relatedImage) ?>');"></div>
                <?php else: ?>
                <div class="related-avatar" style="background: linear-gradient(135deg, <?= $relatedGradient[0] ?>, <?= $relatedGradient[1] ?>);">
                    <?= $relatedInitials ?>
                </div>
                <?php endif; ?>
                <div class="related-info">
                    <span class="related-name"><?= htmlspecialchars($related['nome']) ?></span>
                    <span class="related-type"><?= htmlspecialchars($related['tipo'] ?? '') ?></span>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>
    
    <!-- Back Button -->
    <div class="back-section">
        <a href="<?= $baseUrl ?>/characters" class="btn-back">
            <i class="bi bi-arrow-left"></i>
            Voltar para Personagens
        </a>
    </div>
</div>
