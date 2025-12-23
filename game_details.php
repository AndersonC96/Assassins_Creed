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
    CURLOPT_POSTFIELDS => "fields name, cover.url, summary, storyline, genres.name, platforms.name, release_dates.date, screenshots.url; where id = $gameId;"
]);

$response = curl_exec($curl);
curl_close($curl);
$gameDetails = json_decode($response, true);
$game = (is_array($gameDetails) && !empty($gameDetails)) ? $gameDetails[0] : null;
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $game ? htmlspecialchars($game['name']) : 'Detalhes' ?> - AC Database</title>
    <link rel="icon" href="./IMG/favicon.png" type="image/x-icon" />
    <link rel="stylesheet" href="./CSS/style.css">
</head>
<body>
    <div class="container clearfix">
        <!-- Menu Lateral -->
        <nav id="menu">
            <div class="title">Database</div>
            <ul class="items">
                <li><a href="index.php" class="item">Home</a></li>
                <li><a href="jogos.php" class="item active">Jogos</a></li>
                <li><a href="personagens.php" class="item">Personagens</a></li>
                <li><a href="timeline.php" class="item">Timeline</a></li>
            </ul>
        </nav>

        <!-- Conteúdo Principal -->
        <main id="content">
            <div class="title">Detalhes do Jogo</div>
            
            <?php if ($game): ?>
            <div class="detail-container">
                <img 
                    src="<?= isset($game['cover']['url']) ? 'https:' . str_replace('t_thumb', 't_cover_big_2x', $game['cover']['url']) : './IMG/default_cover.png'; ?>" 
                    alt="<?= htmlspecialchars($game['name']) ?>"
                >
                
                <div class="detail-content">
                    <h2><?= htmlspecialchars($game['name']) ?></h2>
                    
                    <div class="detail-info">
                        <?php if (isset($game['release_dates'][0]['date'])): ?>
                        <div class="detail-info-item">
                            <strong>Data de Lançamento</strong>
                            <span><?= date('d/m/Y', $game['release_dates'][0]['date']) ?></span>
                        </div>
                        <?php endif; ?>
                        
                        <?php if (isset($game['platforms'])): ?>
                        <div class="detail-info-item">
                            <strong>Plataformas</strong>
                            <span><?= implode(', ', array_column($game['platforms'], 'name')) ?></span>
                        </div>
                        <?php endif; ?>
                        
                        <?php if (isset($game['genres'])): ?>
                        <div class="detail-info-item">
                            <strong>Gêneros</strong>
                            <span><?= implode(', ', array_column($game['genres'], 'name')) ?></span>
                        </div>
                        <?php endif; ?>
                    </div>
                    
                    <?php if (isset($game['summary'])): ?>
                    <div class="detail-section">
                        <h3>Resumo</h3>
                        <p><?= nl2br(htmlspecialchars($game['summary'])) ?></p>
                    </div>
                    <?php endif; ?>
                    
                    <?php if (isset($game['storyline'])): ?>
                    <div class="detail-section">
                        <h3>História</h3>
                        <p><?= nl2br(htmlspecialchars($game['storyline'])) ?></p>
                    </div>
                    <?php endif; ?>
                    
                    <?php if (isset($game['screenshots']) && count($game['screenshots']) > 0): ?>
                    <div class="detail-section">
                        <h3>Screenshots</h3>
                        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1em;">
                            <?php foreach (array_slice($game['screenshots'], 0, 6) as $screenshot): ?>
                            <img 
                                src="https:<?= str_replace('t_thumb', 't_screenshot_med', $screenshot['url']) ?>" 
                                alt="Screenshot"
                                style="width: 100%; cursor: pointer; transition: all 0.3s;"
                                onclick="window.open('https:<?= str_replace('t_thumb', 't_screenshot_huge', $screenshot['url']) ?>', '_blank')"
                                loading="lazy"
                            >
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <a href="jogos.php" class="back-btn">← Voltar para Jogos</a>
                </div>
            </div>
            <?php else: ?>
            <div class="description">
                <p><strong>Jogo não encontrado.</strong></p>
                <p><a href="jogos.php">Voltar para a lista de jogos</a></p>
            </div>
            <?php endif; ?>
        </main>
    </div>
</body>
</html>
