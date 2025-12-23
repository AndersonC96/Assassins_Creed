<?php if ($game): 
    $ratingColor = \App\Models\Game::getRatingColor($game['aggregated_rating'] ?? null);
?>
<div class="title">Detalhes do Jogo</div>

<div class="detail-container">
    <img 
        src="<?= isset($game['cover']['url']) ? 'https:' . str_replace('t_thumb', 't_cover_big_2x', $game['cover']['url']) : $baseUrl . '/IMG/default_cover.png' ?>" 
        alt="<?= htmlspecialchars($game['name']) ?>"
    >
    
    <div class="detail-content">
        <div style="display: flex; align-items: center; gap: 1em; margin-bottom: 0.5em;">
            <h2 style="margin: 0;"><?= htmlspecialchars($game['name']) ?></h2>
            <button class="favorite-btn" 
                data-favorite-id="<?= $game['id'] ?>" 
                data-favorite-type="game" 
                data-favorite-name="<?= htmlspecialchars($game['name']) ?>"
                data-favorite-image="<?= isset($game['cover']['url']) ? 'https:' . str_replace('t_thumb', 't_cover_big', $game['cover']['url']) : '' ?>"
                title="Adicionar aos favoritos">
                <i class="bi bi-heart"></i>
            </button>
        </div>
        
        <!-- Breadcrumbs -->
        <div class="breadcrumbs">
            <a href="<?= $baseUrl ?>/" class="breadcrumb-link">Home</a>
            <i class="bi bi-chevron-right breadcrumb-separator"></i>
            <a href="<?= $baseUrl ?>/games" class="breadcrumb-link">Jogos</a>
            <i class="bi bi-chevron-right breadcrumb-separator"></i>
            <span class="breadcrumb-current"><?= htmlspecialchars($game['name']) ?></span>
        </div>
        
        <!-- Ratings -->
        <?php if (isset($game['aggregated_rating']) || isset($game['rating'])): ?>
        <div class="rating-box">
            <?php if (isset($game['aggregated_rating'])): ?>
            <div class="rating-item">
                <div class="rating-score" style="color: <?= $ratingColor ?>"><?= round($game['aggregated_rating']) ?></div>
                <div class="rating-label">Nota da Crítica</div>
                <div class="rating-count"><?= $game['aggregated_rating_count'] ?? 0 ?> reviews</div>
            </div>
            <?php endif; ?>
            <?php if (isset($game['rating'])): ?>
            <div class="rating-item">
                <div class="rating-score"><?= round($game['rating']) ?></div>
                <div class="rating-label">Nota dos Usuários</div>
                <div class="rating-count"><?= $game['rating_count'] ?? 0 ?> votos</div>
            </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>
        
        <!-- Info Grid -->
        <div class="detail-info">
            <?php if (isset($game['release_dates'][0]['date'])): ?>
            <div class="detail-info-item">
                <strong>Lançamento</strong>
                <?= date('d/m/Y', $game['release_dates'][0]['date']) ?>
            </div>
            <?php endif; ?>
            
            <?php if (isset($game['genres'])): ?>
            <div class="detail-info-item">
                <strong>Gêneros</strong>
                <?= implode(', ', array_map(function($g) { return $g['name']; }, $game['genres'])) ?>
            </div>
            <?php endif; ?>
            
            <?php if (isset($game['involved_companies'])): ?>
            <div class="detail-info-item">
                <strong>Desenvolvedora</strong>
                <?php 
                $devs = array_filter($game['involved_companies'], function($c) { return $c['developer']; });
                echo implode(', ', array_map(function($c) { return $c['company']['name']; }, $devs));
                ?>
            </div>
            <?php endif; ?>
        </div>
        
        <!-- Plataformas -->
        <?php if (isset($game['platforms'])): ?>
        <h3 style="font-size: 0.9rem; text-transform: uppercase; color: #666; margin-top: 1.5em;">Plataformas</h3>
        <div class="card-platforms" style="margin-top: 0.5em;">
            <?php foreach ($game['platforms'] as $platform): ?>
            <span class="platform-badge"><?= $platform['name'] ?></span>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
        
        <!-- Sinopse -->
        <?php if (isset($game['summary'])): ?>
        <div style="margin-top: 2em;">
            <h3 style="font-size: 1rem; border-left: 3px solid var(--accent-red); padding-left: 0.5em; margin-bottom: 0.5em;">Sinopse</h3>
            <p style="line-height: 1.6; color: #444;"><?= nl2br(htmlspecialchars($game['summary'])) ?></p>
        </div>
        <?php endif; ?>
        
        <!-- Enredo -->
        <?php if (isset($game['storyline'])): ?>
        <div style="margin-top: 2em;">
            <h3 style="font-size: 1rem; border-left: 3px solid var(--accent-red); padding-left: 0.5em; margin-bottom: 0.5em;">Enredo</h3>
            <p style="line-height: 1.6; color: #444;"><?= nl2br(htmlspecialchars($game['storyline'])) ?></p>
        </div>
        <?php endif; ?>

        <!-- Share Buttons -->
        <div style="margin-top: 2em; padding-top: 1.5em; border-top: 1px solid rgba(0,0,0,0.1);">
            <h3 style="font-size: 0.85rem; text-transform: uppercase; color: #666; margin-bottom: 1em;">Compartilhar</h3>
            <div class="share-buttons">
                <button class="share-btn twitter" onclick="Share.open('twitter', null, 'Confira <?= addslashes($game['name']) ?> no AC Database!')" title="Twitter">
                    <i class="bi bi-twitter-x"></i>
                </button>
                <button class="share-btn facebook" onclick="Share.open('facebook')" title="Facebook">
                    <i class="bi bi-facebook"></i>
                </button>
                <button class="share-btn whatsapp" onclick="Share.open('whatsapp', null, 'Confira <?= addslashes($game['name']) ?> no AC Database!')" title="WhatsApp">
                    <i class="bi bi-whatsapp"></i>
                </button>
                <button class="share-btn copy" onclick="Share.copyLink()" title="Copiar Link">
                    <i class="bi bi-link-45deg"></i>
                </button>
            </div>
        </div>

        <a href="<?= $baseUrl ?>/games" class="back-btn">← Voltar para Jogos</a>
    </div>
</div>
<?php else: ?>
<div class="description">
    <p><strong>Jogo não encontrado.</strong></p>
    <p><a href="<?= $baseUrl ?>/games">Voltar para a lista de jogos</a></p>
</div>
<?php endif; ?>
