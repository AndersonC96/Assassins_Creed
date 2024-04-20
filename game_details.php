<?php
// Obtenha o ID do jogo a partir do URL
$gameId = $_GET['game_id'] ?? null;

if (!$gameId) {
    echo "Jogo não especificado!";
    exit;
}

$accessToken = 'j11t1w7bvlfvv98265bcldopqt33v3';
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
    CURLOPT_POSTFIELDS => "fields name, cover.url, summary, genres.name, platforms.name, release_dates.date, screenshots.url; where category = 0 & id = $gameId;"
]);

$response = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);
$gameDetails = json_decode($response, true);

if ($err) {
    echo "cURL Error #:" . $err;
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Jogo</title>
    <link rel="icon" href="./IMG/favicon.png" type="image/x-icon" />
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.0/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./CSS/style.css">
</head>
<body>
    <header class="header">
        <h1>Detalhes do Jogo</h1>
        <p>Explore mais sobre o título selecionado.</p>
    </header>
    <nav class="flex justify-center mt-4">
            <a href="index.php" class="nav-link">Home</a>
            <a href="jogos.php" class="nav-link">Jogos</a>
            <a href="livros.php" class="nav-link">Livros</a>
            <a href="hqs.php" class="nav-link">HQs</a>
            <a href="personagens.php" class="nav-link">Personagens Principais</a>
            <a href="historicos.php" class="nav-link">Personagens Históricos</a>
            <a href="locais.php" class="nav-link">Locais</a>
            <a href="noticias.php" class="nav-link">Notícias</a>
            <a href="database.php" class="nav-link">Banco de Dados</a>
        </nav>
    <div class="game-details">
        <?php if (!empty($gameDetails)): ?>
            <?php foreach ($gameDetails as $detail): ?>
                <div class="detail-card">
                    <img src="<?= $detail['cover']['url'] ?? 'path/to/default/cover.jpg'; ?>" alt="Cover Image">
                    <h3><?= htmlspecialchars($detail['name']) ?></h3>
                    <hr>
                    <p>Data de lançamento: <?= date('d/m/Y', $detail['release_dates'][0]['date']) ?></p>
                    <p>Plataformas: <?= implode(', ', array_column($detail['platforms'], 'name')) ?></p>
                    <p>Gêneros: <?= implode(', ', array_column($detail['genres'], 'name')) ?></p>
                    <hr>
                    <p><?= htmlspecialchars($detail['summary']) ?></p>
                    <hr>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No details found for this game.</p>
        <?php endif; ?>
    </div>
</body>
</html>
