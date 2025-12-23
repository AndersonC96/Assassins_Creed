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

        <!-- Game Modes -->
        <?php if (isset($game['game_modes'])): ?>
        <div class="detail-section">
            <h3 class="section-title">Modos de Jogo</h3>
            <div class="game-modes">
                <?php foreach ($game['game_modes'] as $mode): ?>
                <span class="game-mode-badge"><?= htmlspecialchars($mode['name']) ?></span>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- Age Ratings -->
        <?php if (isset($game['age_ratings']) && count($game['age_ratings']) > 0): ?>
        <div class="detail-section">
            <h3 class="section-title">Classificação Etária</h3>
            <div class="age-ratings">
                <?php foreach ($game['age_ratings'] as $ageRating): 
                    if (!isset($ageRating['organization']) || !isset($ageRating['rating_category'])) continue;
                    $orgName = \App\Models\Game::getAgeRatingOrganization($ageRating['organization']);
                    $ratingLabel = \App\Models\Game::getAgeRatingLabel($ageRating['organization'], $ageRating['rating_category']);
                ?>
                <div class="age-rating-badge">
                    <span class="age-rating-org"><?= $orgName ?></span>
                    <span class="age-rating-value"><?= $ratingLabel ?></span>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- Screenshots Gallery -->
        <?php if (isset($game['screenshots']) && count($game['screenshots']) > 0): ?>
        <div class="detail-section">
            <h3 class="section-title">Screenshots</h3>
            <div class="media-gallery">
                <?php foreach ($game['screenshots'] as $ss): 
                    $thumbUrl = 'https:' . str_replace('t_thumb', 't_screenshot_med', $ss['url']);
                    $fullUrl = 'https:' . str_replace('t_thumb', 't_screenshot_huge', $ss['url']);
                ?>
                <a href="<?= $fullUrl ?>" target="_blank" class="gallery-item">
                    <img src="<?= $thumbUrl ?>" alt="Screenshot" loading="lazy">
                </a>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- Artworks Gallery -->
        <?php if (isset($game['artworks']) && count($game['artworks']) > 0): ?>
        <div class="detail-section">
            <h3 class="section-title">Artes Conceituais</h3>
            <div class="media-gallery">
                <?php foreach ($game['artworks'] as $art): 
                    $thumbUrl = 'https:' . str_replace('t_thumb', 't_screenshot_med', $art['url']);
                    $fullUrl = 'https:' . str_replace('t_thumb', 't_1080p', $art['url']);
                ?>
                <a href="<?= $fullUrl ?>" target="_blank" class="gallery-item">
                    <img src="<?= $thumbUrl ?>" alt="Artwork" loading="lazy">
                </a>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- Videos/Trailers Carousel -->
        <?php if (isset($game['videos']) && count($game['videos']) > 0): 
            $videos = $game['videos'];
            $totalVideos = count($videos);
        ?>
        <div class="detail-section">
            <h3 class="section-title">Trailers e Vídeos <span class="video-counter">(1/<?= $totalVideos ?>)</span></h3>
            <div class="video-carousel">
                <button class="carousel-btn carousel-prev" onclick="changeVideo(-1)" aria-label="Vídeo anterior">
                    <i class="bi bi-chevron-left"></i>
                </button>
                
                <div class="carousel-container">
                    <?php foreach ($videos as $index => $video): ?>
                    <div class="carousel-slide <?= $index === 0 ? 'active' : '' ?>" data-index="<?= $index ?>">
                        <iframe 
                            src="<?= $index === 0 ? 'https://www.youtube.com/embed/' . $video['video_id'] : '' ?>" 
                            data-src="https://www.youtube.com/embed/<?= $video['video_id'] ?>"
                            title="<?= htmlspecialchars($video['name'] ?? 'Trailer') ?>"
                            frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen>
                        </iframe>
                        <p class="video-title"><?= htmlspecialchars($video['name'] ?? 'Trailer') ?></p>
                    </div>
                    <?php endforeach; ?>
                </div>
                
                <button class="carousel-btn carousel-next" onclick="changeVideo(1)" aria-label="Próximo vídeo">
                    <i class="bi bi-chevron-right"></i>
                </button>
            </div>
            
            <?php if ($totalVideos > 1): ?>
            <div class="carousel-indicators">
                <?php for ($i = 0; $i < $totalVideos; $i++): ?>
                <button class="indicator <?= $i === 0 ? 'active' : '' ?>" onclick="goToVideo(<?= $i ?>)" aria-label="Ir para vídeo <?= $i + 1 ?>"></button>
                <?php endfor; ?>
            </div>
            <?php endif; ?>
        </div>
        
        <script>
        let currentVideoIndex = 0;
        const totalVideos = <?= $totalVideos ?>;
        
        function changeVideo(direction) {
            const newIndex = (currentVideoIndex + direction + totalVideos) % totalVideos;
            goToVideo(newIndex);
        }
        
        function goToVideo(index) {
            const slides = document.querySelectorAll('.carousel-slide');
            const indicators = document.querySelectorAll('.carousel-indicators .indicator');
            const counter = document.querySelector('.video-counter');
            
            // Stop current video by clearing src
            const currentIframe = slides[currentVideoIndex].querySelector('iframe');
            currentIframe.src = '';
            
            // Hide current slide
            slides[currentVideoIndex].classList.remove('active');
            if (indicators[currentVideoIndex]) indicators[currentVideoIndex].classList.remove('active');
            
            // Show new slide
            currentVideoIndex = index;
            slides[currentVideoIndex].classList.add('active');
            if (indicators[currentVideoIndex]) indicators[currentVideoIndex].classList.add('active');
            
            // Load new video
            const newIframe = slides[currentVideoIndex].querySelector('iframe');
            newIframe.src = newIframe.dataset.src;
            
            // Update counter
            if (counter) counter.textContent = `(${currentVideoIndex + 1}/${totalVideos})`;
        }
        </script>
        <?php endif; ?>

        <!-- Similar Games -->
        <?php if (isset($game['similar_games']) && count($game['similar_games']) > 0): ?>
        <div class="detail-section">
            <h3 class="section-title">Jogos Similares</h3>
            <div class="similar-games-scroll">
                <?php foreach (array_slice($game['similar_games'], 0, 8) as $similar): ?>
                <a href="<?= $baseUrl ?>/games/show/<?= $similar['id'] ?>" class="similar-game-card">
                    <img src="<?= isset($similar['cover']['url']) ? 'https:' . str_replace('t_thumb', 't_cover_big', $similar['cover']['url']) : $baseUrl . '/IMG/default_cover.png' ?>" 
                         alt="<?= htmlspecialchars($similar['name']) ?>" loading="lazy">
                    <span class="similar-game-name"><?= htmlspecialchars($similar['name']) ?></span>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- Official Links -->
        <?php if (isset($game['websites']) && count($game['websites']) > 0): ?>
        <div class="detail-section">
            <h3 class="section-title">Links Oficiais</h3>
            <div class="official-links">
                <?php foreach ($game['websites'] as $website): 
                    if (!isset($website['type'])) continue;
                    $info = \App\Models\Game::getWebsiteInfo($website['type']);
                ?>
                <a href="<?= htmlspecialchars($website['url']) ?>" target="_blank" class="official-link-btn">
                    <i class="bi <?= $info['icon'] ?>"></i> <?= $info['label'] ?>
                </a>
                <?php endforeach; ?>
            </div>
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
