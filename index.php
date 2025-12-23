<?php include 'db_config.php'; ?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assassin's Creed - Database</title>
    <meta name="description" content="Portal dedicado ao universo Assassin's Creed no estilo Animus.">
    <link rel="icon" href="./IMG/favicon.png" type="image/x-icon" />
    <link rel="stylesheet" href="./CSS/style.css">
</head>
<body>
    <div class="container clearfix">
        <!-- Menu Lateral (Estilo Animus) -->
        <nav id="menu">
            <div class="title">Database</div>
            <ul class="items">
                <li><a href="index.php" class="item active">Home</a></li>
                <li><a href="jogos.php" class="item">Jogos</a></li>
                <li><a href="personagens.php" class="item">Personagens</a></li>
                <li><a href="timeline.php" class="item">Timeline</a></li>
            </ul>
        </nav>

        <!-- Conteúdo Principal -->
        <main id="content">
            <div class="title">Animus Database</div>
            
            <div class="description">
                <p>Bem-vindo ao <strong>Animus Database</strong>, o portal dedicado ao universo <em>Assassin's Creed</em>.</p>
                <p>Explore as memórias genéticas de lendários Assassinos através das eras. <strong>Selecione</strong> uma opção no menu para começar.</p>
            </div>

            <!-- Video Player -->
            <?php if (isset($video) && $video): ?>
            <div class="video-container">
                <div class="video-header">
                    <span class="video-title"><?= htmlspecialchars($video['titulo'] ?? 'Trailer') ?></span>
                    <button class="video-control" id="playPauseBtn" onclick="togglePlayPause()">▶ PLAY</button>
                </div>
                <video id="videoPlayer">
                    <source src="<?= htmlspecialchars($video['url'] ?? '') ?>" type="video/mp4">
                    Seu navegador não suporta vídeo.
                </video>
            </div>
            <?php endif; ?>

            <!-- Quick Access Cards -->
            <div class="cards-grid">
                <div class="card">
                    <div style="height: 120px; background: linear-gradient(135deg, #333 0%, #555 100%); display: flex; align-items: center; justify-content: center;">
                        <span style="font-size: 3rem;">🎮</span>
                    </div>
                    <div class="card-content">
                        <div class="card-title">Jogos</div>
                        <div class="card-desc">Todos os títulos da franquia, de Altaïr a Basim.</div>
                        <a href="jogos.php" class="card-btn">Acessar</a>
                    </div>
                </div>

                <div class="card">
                    <div style="height: 120px; background: linear-gradient(135deg, #333 0%, #555 100%); display: flex; align-items: center; justify-content: center;">
                        <span style="font-size: 3rem;">👤</span>
                    </div>
                    <div class="card-content">
                        <div class="card-title">Personagens</div>
                        <div class="card-desc">Os assassinos lendários que moldaram a história.</div>
                        <a href="personagens.php" class="card-btn">Acessar</a>
                    </div>
                </div>

                <div class="card">
                    <div style="height: 120px; background: linear-gradient(135deg, #333 0%, #555 100%); display: flex; align-items: center; justify-content: center;">
                        <span style="font-size: 3rem;">📅</span>
                    </div>
                    <div class="card-content">
                        <div class="card-title">Timeline</div>
                        <div class="card-desc">Cronologia completa do universo AC.</div>
                        <a href="timeline.php" class="card-btn">Acessar</a>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        const videoPlayer = document.getElementById('videoPlayer');
        const playPauseBtn = document.getElementById('playPauseBtn');
        
        function togglePlayPause() {
            if (!videoPlayer) return;
            if (videoPlayer.paused || videoPlayer.ended) {
                videoPlayer.play();
                playPauseBtn.textContent = '⏸ PAUSAR';
            } else {
                videoPlayer.pause();
                playPauseBtn.textContent = '▶ PLAY';
            }
        }

        if (videoPlayer) {
            videoPlayer.addEventListener('ended', () => {
                playPauseBtn.textContent = '▶ PLAY';
            });
        }
    </script>
</body>
</html>