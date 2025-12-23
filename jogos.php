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
        CURLOPT_POSTFIELDS => "fields name, cover.url, summary, first_release_date; where id = ($specificGameIds) & collections = ($collections); sort first_release_date asc; limit 100;"
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
    <title>Jogos - Assassin's Creed Database</title>
    <meta name="description" content="Lista completa de todos os jogos da franquia Assassin's Creed.">
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
            <div class="title">Jogos da Saga</div>
            
            <div class="description">
                <p>Explore todos os títulos da franquia <em>Assassin's Creed</em> através de diferentes épocas e histórias.</p>
                <p><strong>Passe o mouse</strong> sobre um jogo para ver o efeito de seleção.</p>
            </div>

            <!-- Games Grid -->
            <div class="cards-grid">
                <?php if (is_array($games) && !empty($games) && !isset($games['message'])): ?>
                    <?php foreach ($games as $game): ?>
                    <div class="card">
                        <img 
                            src="<?= isset($game['cover']['url']) ? 'https:' . str_replace('t_thumb', 't_cover_big', $game['cover']['url']) : './IMG/default_cover.png'; ?>" 
                            alt="<?= htmlspecialchars($game['name'] ?? 'Game Cover') ?>"
                            loading="lazy"
                        >
                        <div class="card-content">
                            <div class="card-title"><?= htmlspecialchars($game['name'] ?? 'Nome não disponível') ?></div>
                            <?php if (isset($game['first_release_date'])): ?>
                                <div class="card-year"><?= date('Y', $game['first_release_date']) ?></div>
                            <?php endif; ?>
                            <div class="card-desc"><?= isset($game['summary']) ? htmlspecialchars(mb_strimwidth($game['summary'], 0, 120, '...')) : 'Nenhum resumo disponível'; ?></div>
                            <a href="game_details.php?game_id=<?= $game['id']; ?>" class="card-btn">Ver Detalhes</a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="description" style="grid-column: 1 / -1;">
                        <p><strong>Erro ao carregar jogos.</strong></p>
                        <p>O token de acesso pode ter expirado. <a href="get_token.php">Clique aqui</a> para gerar um novo.</p>
                    </div>
                <?php endif; ?>
            </div>
        </main>
    </div>
</body>
</html>