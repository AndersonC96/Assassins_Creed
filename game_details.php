<?php
$gameId = $_GET['game_id'] ?? null;

if (!$gameId) {
    header('Location: jogos.php');
    exit;
}

$accessToken = 'l6p3tnk3677zj5qdtlz095pngs48jn';
$clientID = 'dytp463ksb6k09r6e4nqkhp6u8gt62';

$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => "https://api.igdb.com/v4/games",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => [
        "Client-ID: $clientID",
        "Authorization: Bearer $accessToken",
        "Accept: application/json"
    ],
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => "fields name, cover.url, summary, storyline, genres.name, platforms.name, release_dates.date, screenshots.url, videos.video_id; where id = $gameId;"
]);

$response = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);
$gameDetails = json_decode($response, true);
$game = (is_array($gameDetails) && !empty($gameDetails)) ? $gameDetails[0] : null;
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $game ? htmlspecialchars($game['name']) : 'Detalhes do Jogo' ?> - Assassin's Creed Portal</title>
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
                <li><a href="index.php" class="nav-link">Home</a></li>
                <li><a href="jogos.php" class="nav-link active">Jogos</a></li>
                <li><a href="personagens.php" class="nav-link">Personagens</a></li>
                <li><a href="timeline.php" class="nav-link">Timeline</a></li>
            </ul>
        </div>
    </nav>

    <!-- Content -->
    <div class="game-details">
        <?php if ($game): ?>
            <div class="detail-card animate-fadeInUp">
                <!-- Cover Image -->
                <img 
                    src="<?= isset($game['cover']['url']) ? 'https:' . str_replace('t_thumb', 't_cover_big_2x', $game['cover']['url']) : './IMG/default_cover.png'; ?>" 
                    alt="<?= htmlspecialchars($game['name']) ?>"
                >
                
                <div class="detail-content">
                    <h3><?= htmlspecialchars($game['name']) ?></h3>
                    
                    <!-- Info Grid -->
                    <div class="detail-info">
                        <?php if (isset($game['release_dates'][0]['date'])): ?>
                        <div class="detail-info-item">
                            <strong>Data de Lançamento</strong>
                            <?= date('d/m/Y', $game['release_dates'][0]['date']) ?>
                        </div>
                        <?php endif; ?>
                        
                        <?php if (isset($game['platforms'])): ?>
                        <div class="detail-info-item">
                            <strong>Plataformas</strong>
                            <?= implode(', ', array_column($game['platforms'], 'name')) ?>
                        </div>
                        <?php endif; ?>
                        
                        <?php if (isset($game['genres'])): ?>
                        <div class="detail-info-item">
                            <strong>Gêneros</strong>
                            <?= implode(', ', array_column($game['genres'], 'name')) ?>
                        </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Summary -->
                    <?php if (isset($game['summary'])): ?>
                    <div style="margin-bottom: 1.5rem;">
                        <h4 style="color: var(--animus-accent); font-size: 0.9rem; margin-bottom: 0.75rem; text-transform: uppercase; letter-spacing: 0.1em;">Resumo</h4>
                        <p style="line-height: 1.8;"><?= nl2br(htmlspecialchars($game['summary'])) ?></p>
                    </div>
                    <?php endif; ?>
                    
                    <!-- Storyline -->
                    <?php if (isset($game['storyline'])): ?>
                    <div style="margin-bottom: 1.5rem;">
                        <h4 style="color: var(--animus-accent); font-size: 0.9rem; margin-bottom: 0.75rem; text-transform: uppercase; letter-spacing: 0.1em;">História</h4>
                        <p style="line-height: 1.8;"><?= nl2br(htmlspecialchars($game['storyline'])) ?></p>
                    </div>
                    <?php endif; ?>
                    
                    <!-- Screenshots -->
                    <?php if (isset($game['screenshots']) && count($game['screenshots']) > 0): ?>
                    <div style="margin-top: 2rem;">
                        <h4 style="color: var(--animus-accent); font-size: 0.9rem; margin-bottom: 1rem; text-transform: uppercase; letter-spacing: 0.1em;">Screenshots</h4>
                        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1rem;">
                            <?php foreach (array_slice($game['screenshots'], 0, 6) as $screenshot): ?>
                            <img 
                                src="https:<?= str_replace('t_thumb', 't_screenshot_med', $screenshot['url']) ?>" 
                                alt="Screenshot"
                                style="width: 100%; border-radius: 8px; border: 1px solid var(--glass-border); cursor: pointer; transition: all 0.3s ease;"
                                onclick="window.open('https:<?= str_replace('t_thumb', 't_screenshot_huge', $screenshot['url']) ?>', '_blank')"
                                loading="lazy"
                            >
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <!-- Back Button -->
                    <div style="margin-top: 2rem; text-align: center;">
                        <a href="jogos.php" class="btn btn-primary">← Voltar para Jogos</a>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="error-card">
                <h3>⚠️ Jogo não encontrado</h3>
                <p>Não foi possível carregar os detalhes deste jogo.</p>
                <a href="jogos.php" class="btn btn-primary" style="margin-top: 1.5rem; display: inline-block;">Voltar para Jogos</a>
            </div>
        <?php endif; ?>
    </div>

    <script>
        function toggleMenu() {
            document.getElementById('navMenu').classList.toggle('active');
        }
    </script>
</body>
</html>
