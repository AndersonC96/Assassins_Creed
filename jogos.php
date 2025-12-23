<?php
    $accessToken = 'l6p3tnk3677zj5qdtlz095pngs48jn';
    $clientID = 'dytp463ksb6k09r6e4nqkhp6u8gt62';
    $collections = 18;
    $specificGameIds = "68526,128,21349,68527,18865,10661,127,77265,537,77209,68529,113,68528,3195,1266,68530,1970,20077,8263,8223,5606,7570,17028,64759,3775,14902,14903,251353,28540,103054,111830,81205,41030,26917,109532,135506,133962,133004,215060,152231,251568,216319,216321,216320,64765,64737";
    
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
        CURLOPT_POSTFIELDS => "fields name, cover.url, summary, storyline, first_release_date; where id = ($specificGameIds) & collections = ($collections); sort first_release_date asc; limit 100;"
    ]);
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    $games = json_decode($response, true);
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jogos - Assassin's Creed Portal</title>
    <meta name="description" content="Lista completa de todos os jogos da franquia Assassin's Creed, de 2007 até hoje.">
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

    <!-- Header -->
    <header class="header">
        <h1>Jogos da Saga</h1>
        <p>Explore todos os títulos da franquia Assassin's Creed através de diferentes épocas e histórias.</p>
    </header>

    <!-- Games Grid -->
    <div class="game-list">
        <?php if (is_array($games) && !empty($games) && !isset($games['message'])): ?>
            <?php foreach ($games as $index => $game): ?>
            <div class="game-card animate-fadeInUp" style="animation-delay: <?= $index * 0.05 ?>s;">
                <img 
                    src="<?= isset($game['cover']['url']) ? 'https:' . str_replace('t_thumb', 't_cover_big', $game['cover']['url']) : './IMG/default_cover.png'; ?>" 
                    alt="<?= htmlspecialchars($game['name'] ?? 'Game Cover') ?>"
                    loading="lazy"
                >
                <div class="game-card-content">
                    <h3><?= htmlspecialchars($game['name'] ?? 'Nome não disponível') ?></h3>
                    <?php if (isset($game['first_release_date'])): ?>
                        <p style="color: var(--animus-accent); font-size: 0.8rem; margin-bottom: 0.5rem;">
                            📅 <?= date('Y', $game['first_release_date']) ?>
                        </p>
                    <?php endif; ?>
                    <p><?= isset($game['summary']) ? htmlspecialchars(mb_strimwidth($game['summary'], 0, 150, '...')) : 'Nenhum resumo disponível'; ?></p>
                    <a href="game_details.php?game_id=<?= $game['id']; ?>" class="exibir-mais-btn">Ver Detalhes</a>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="error-card" style="grid-column: 1 / -1; max-width: 600px; margin: 0 auto;">
                <h3>⚠️ Erro ao carregar jogos</h3>
                <p>Não foi possível carregar os jogos da API IGDB. O token de acesso pode ter expirado.</p>
                <p style="margin-top: 1rem;">
                    <a href="get_token.php" class="btn btn-primary">Gerar Novo Token</a>
                </p>
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