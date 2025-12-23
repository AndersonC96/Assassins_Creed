<?php include 'db_config.php'; ?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assassin's Creed - Portal</title>
    <meta name="description" content="Portal dedicado ao universo Assassin's Creed. Explore jogos, personagens, história e muito mais.">
    <link rel="icon" href="./IMG/favicon.png" type="image/x-icon" />
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&family=Roboto:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./CSS/style.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbar-container">
            <a href="index.php" class="navbar-brand">
                <img src="./IMG/favicon.png" alt="AC Logo" class="navbar-logo">
                <span class="navbar-title">Animus</span>
            </a>
            <button class="hamburger" onclick="toggleMenu()" aria-label="Menu">
                <span></span>
                <span></span>
                <span></span>
            </button>
            <ul class="navbar-menu" id="navMenu">
                <li><a href="index.php" class="nav-link active">Home</a></li>
                <li><a href="jogos.php" class="nav-link">Jogos</a></li>
                <li><a href="personagens.php" class="nav-link">Personagens</a></li>
                <li><a href="timeline.php" class="nav-link">Timeline</a></li>
            </ul>
        </div>
    </nav>

    <!-- Header -->
    <header class="header">
        <h1>Bem-vindo ao Animus</h1>
        <p>Explore a saga Assassin's Creed através de diferentes épocas e reviva as memórias de lendários assassinos.</p>
    </header>

    <!-- Video Player -->
    <div class="video-container">
        <div class="video-header">
            <span class="video-title"><?= htmlspecialchars($video['titulo'] ?? 'Trailer') ?></span>
            <button class="video-control" id="playPauseBtn" onclick="togglePlayPause()">▶ Play</button>
        </div>
        <video id="videoPlayer">
            <source src="<?= htmlspecialchars($video['url'] ?? '') ?>" type="video/mp4">
            Seu navegador não suporta vídeo.
        </video>
    </div>

    <!-- Featured Games Section -->
    <section style="padding: 2rem; max-width: 1400px; margin: 0 auto;">
        <h2 class="text-center mb-3">Explore a Saga</h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem;">
            <div class="card animate-fadeInUp" style="text-align: center;">
                <h3 style="margin-bottom: 1rem; font-size: 1.1rem;">🎮 Jogos</h3>
                <p style="margin-bottom: 1.5rem;">Descubra todos os títulos da franquia, de Altaïr a Basim.</p>
                <a href="jogos.php" class="btn btn-primary">Ver Jogos</a>
            </div>
            <div class="card animate-fadeInUp" style="text-align: center; animation-delay: 0.1s;">
                <h3 style="margin-bottom: 1rem; font-size: 1.1rem;">👤 Personagens</h3>
                <p style="margin-bottom: 1.5rem;">Conheça os assassinos e templários que moldaram a história.</p>
                <a href="personagens.php" class="btn btn-primary">Ver Personagens</a>
            </div>
            <div class="card animate-fadeInUp" style="text-align: center; animation-delay: 0.2s;">
                <h3 style="margin-bottom: 1rem; font-size: 1.1rem;">📅 Timeline</h3>
                <p style="margin-bottom: 1.5rem;">Explore a cronologia completa do universo AC.</p>
                <a href="timeline.php" class="btn btn-primary">Ver Timeline</a>
            </div>
        </div>
    </section>

    <script>
        // Video Player Controls
        const videoPlayer = document.getElementById('videoPlayer');
        const playPauseBtn = document.getElementById('playPauseBtn');
        
        function togglePlayPause() {
            if (videoPlayer.paused || videoPlayer.ended) {
                videoPlayer.play();
                playPauseBtn.textContent = '⏸ Pausar';
            } else {
                videoPlayer.pause();
                playPauseBtn.textContent = '▶ Play';
            }
        }

        videoPlayer.addEventListener('ended', () => {
            playPauseBtn.textContent = '▶ Play';
        });

        // Mobile Menu Toggle
        function toggleMenu() {
            const menu = document.getElementById('navMenu');
            menu.classList.toggle('active');
        }

        // Close menu when clicking a link
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', () => {
                document.getElementById('navMenu').classList.remove('active');
            });
        });
    </script>
</body>
</html>